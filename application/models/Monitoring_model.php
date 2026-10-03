<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_model extends CI_Model
{
    public function initialize()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS monitoring_sections (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL, sort_order INT NOT NULL DEFAULT 0,
            monitor_id INT UNSIGNED NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        if (!$this->db->field_exists('monitor_id', 'monitoring_sections')) {
            $this->db->query('ALTER TABLE monitoring_sections ADD monitor_id INT UNSIGNED NULL DEFAULT NULL');
        }
        $this->db->query("CREATE TABLE IF NOT EXISTS monitoring_section_monitors (
            section_id INT UNSIGNED NOT NULL, monitor_id INT UNSIGNED NOT NULL,
            PRIMARY KEY (section_id, monitor_id), KEY monitor_id (monitor_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $this->db->query("CREATE TABLE IF NOT EXISTS monitoring_indicators (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            section_id INT UNSIGNED NOT NULL, description TEXT NOT NULL,
            sort_order INT NOT NULL DEFAULT 0, KEY section_id (section_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $this->db->query("CREATE TABLE IF NOT EXISTS monitoring_catalog_state (
            id INT NOT NULL PRIMARY KEY, seeded TINYINT NOT NULL DEFAULT 0
        ) ENGINE=InnoDB");
        $this->db->query('INSERT IGNORE INTO monitoring_catalog_state (id, seeded) VALUES (1, 0)');
        $this->db->trans_begin();
        $state = $this->db->query('SELECT seeded FROM monitoring_catalog_state WHERE id = 1 FOR UPDATE')->row();
        // Move legacy assignments once, under the catalog lock, preserving existing selections.
        $this->db->query('INSERT IGNORE INTO monitoring_section_monitors (section_id, monitor_id) SELECT id, monitor_id FROM monitoring_sections WHERE monitor_id IS NOT NULL');
        $this->db->query('UPDATE monitoring_sections SET monitor_id = NULL WHERE monitor_id IS NOT NULL');
        if (!$state->seeded) {
            $original = $this->original_definition();
            foreach ($original['sections'] as $position => $section) {
                $this->db->insert('monitoring_sections', array('title' => preg_replace('/^\d+\.\s*/', '', $section['title']), 'sort_order' => $position + 1));
                $section_id = $this->db->insert_id();
                foreach ($section['items'] as $order => $item) {
                    $this->db->insert('monitoring_indicators', array('section_id' => $section_id, 'description' => $item, 'sort_order' => $order + 1));
                }
            }
            $this->db->where('id', 1)->update('monitoring_catalog_state', array('seeded' => 1));
        }
        if (!$this->finish_transaction()) {
            show_error('Monitoring indicators could not be initialized. Please try again.', 500);
        }
    }

    public function original_definition()
    {
        return json_decode(file_get_contents(APPPATH . 'config/monitoring_tool.json'), true);
    }

    public function sections()
    {
        $sections = $this->db->order_by('sort_order')->order_by('id')->get('monitoring_sections')->result_array();
        $assignments = array();
        foreach ($this->db->order_by('monitor_id')->get('monitoring_section_monitors')->result_array() as $assignment) {
            $assignments[$assignment['section_id']][] = (int) $assignment['monitor_id'];
        }
        foreach ($sections as &$section) { $section['monitor_ids'] = $assignments[$section['id']] ?? array(); }
        unset($section);
        return $sections;
    }

    public function add_monitor_names($records)
    {
        if (!$records) { return; }
        $school_key = function ($record, $values) {
            $school = !empty($values['school_rec_id']) ? 'id:' . $values['school_rec_id']
                : 'name:' . json_encode(array($values['division'] ?? '', $values['district'] ?? '', $record->school_name));
            return json_encode(array($record->school_year, $school));
        };
        $groups = array(); $years = array();
        foreach ($records as $record) {
            $groups[$school_key($record, $record->details)] = array();
            $years[] = $record->school_year;
        }
        // Fetch contributor names only; ownership still controls the visible assessments.
        $contributors = $this->db->select('r.school_name, r.school_year, r.created_by, r.payload')
            ->from('monitoring_tool_records r')
            ->where_in('r.school_year', array_unique($years))->order_by('r.updated_at', 'DESC')->order_by('r.id', 'DESC')->get()->result();
        // Resolve names separately: legacy tables can use different username collations.
        $usernames = array_values(array_unique(array_map(function ($record) { return $record->created_by; }, $contributors)));
        $account_names = array();
        if ($usernames) {
            $accounts = $this->db->select('username, fname, mname, lname')->where_in('username', $usernames)->get('users')->result();
            foreach ($accounts as $account) {
                $account_names[$account->username] = implode(' ', array_filter(array_map('trim', array(
                    (string) $account->fname, (string) $account->mname, (string) $account->lname
                )), 'strlen'));
            }
        }
        foreach ($contributors as $contributor) {
            $values = json_decode($contributor->payload, true) ?: array();
            $key = $school_key($contributor, $values);
            if (!isset($groups[$key]) || isset($groups[$key][$contributor->created_by])) { continue; }
            $name = $account_names[$contributor->created_by] ?? '';
            $saved_name = $values['prepared_by'] ?? '';
            $groups[$key][$contributor->created_by] = $name !== '' ? $name
                : (is_string($saved_name) && trim($saved_name) !== '' ? trim($saved_name) : 'Name not recorded');
        }
        foreach ($records as $record) {
            $names = array_values($groups[$school_key($record, $record->details)]);
            natcasesort($names);
            $record->monitor_names = array_values($names);
        }
    }

    public function indicators()
    {
        return $this->db->order_by('sort_order')->order_by('id')->get('monitoring_indicators')->result_array();
    }

    public function definition($monitor_id = null)
    {
        $definition = $this->original_definition();
        $definition['sections'] = array();
        $items = $this->indicators();
        foreach ($this->sections() as $section) {
            if ($monitor_id !== null && !in_array((int) $monitor_id, $section['monitor_ids'], true)) { continue; }
            $group = array('title' => (count($definition['sections']) + 1) . '. ' . $section['title'], 'items' => array());
            if ($monitor_id !== null) { $group['id'] = (int) $section['id']; }
            foreach ($items as $item) {
                if ($item['section_id'] == $section['id']) { $group['items'][] = $item['description']; }
            }
            if ($group['items']) { $definition['sections'][] = $group; }
        }
        return $definition;
    }

    public function allows_definition($monitor_id, $definition)
    {
        $allowed = array();
        foreach ($this->sections() as $section) {
            if (in_array((int) $monitor_id, $section['monitor_ids'], true)) { $allowed[] = (string) $section['id']; }
        }
        foreach ($definition['sections'] as $section) {
            if (empty($section['id']) || !in_array((string) $section['id'], $allowed, true)) { return false; }
        }
        return true;
    }

    public function change($entity, $action, $id, $data)
    {
        $table = $entity === 'section' ? 'monitoring_sections' : 'monitoring_indicators';
        $this->db->trans_begin();
        // Serialize catalog changes with initialization and section deletion.
        $this->db->query('SELECT id FROM monitoring_catalog_state WHERE id = 1 FOR UPDATE');
        if ($action !== 'create' && !$this->db->get_where($table, array('id' => $id))->row()) {
            $this->db->trans_rollback();
            return 'This entry no longer exists. Reload Settings.';
        }
        if ($entity === 'indicator' && $action !== 'delete'
            && !$this->db->get_where('monitoring_sections', array('id' => $data['section_id']))->row()) {
            $this->db->trans_rollback();
            return 'Select an existing Domain.';
        }
        $monitor_ids = array();
        if ($entity === 'section' && $action !== 'delete') {
            $monitor_ids = $data['monitor_ids'] ?? array();
            if (!is_array($monitor_ids)) {
                $this->db->trans_rollback();
                return 'Select valid monitors.';
            }
            foreach ($monitor_ids as $monitor_id) {
                if ((!is_string($monitor_id) && !is_int($monitor_id)) || !ctype_digit((string) $monitor_id)
                    || (int) $monitor_id < 1 || !$this->db->get_where('monitoring_monitors', array('id' => $monitor_id))->row()) {
                    $this->db->trans_rollback();
                    return 'Select existing monitors. A selected monitor may have been deleted.';
                }
            }
            $monitor_ids = array_unique(array_map('intval', $monitor_ids));
            unset($data['monitor_ids']);
            $data['monitor_id'] = null;
        }
        if ($entity === 'section' && $action === 'delete'
            && $this->db->where('section_id', $id)->count_all_results('monitoring_indicators') > 0) {
            $this->db->trans_rollback();
            return 'Move or delete this Domain’s indicators before deleting the Domain.';
        }
        if ($action === 'create') { $this->db->insert($table, $data); $id = $this->db->insert_id(); }
        elseif ($action === 'update') { $this->db->where('id', $id)->update($table, $data); }
        else { $this->db->where('id', $id)->delete($table); }
        if ($entity === 'section') {
            $this->db->where('section_id', $id)->delete('monitoring_section_monitors');
            if ($action !== 'delete') {
                foreach ($monitor_ids as $monitor_id) {
                    $this->db->insert('monitoring_section_monitors', array('section_id' => $id, 'monitor_id' => $monitor_id));
                }
            }
        }
        return $this->finish_transaction() ? null : 'The change could not be saved. Please try again.';
    }

    private function finish_transaction()
    {
        if ($this->db->trans_status() === false) { $this->db->trans_rollback(); return false; }
        $this->db->trans_commit();
        return true;
    }
}
