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
        return $this->db->order_by('sort_order')->order_by('id')->get('monitoring_sections')->result_array();
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
            if ($monitor_id !== null && (string) $section['monitor_id'] !== (string) $monitor_id) { continue; }
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
            if ((string) $section['monitor_id'] === (string) $monitor_id) { $allowed[] = (string) $section['id']; }
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
        if ($entity === 'section' && $action !== 'delete' && !empty($data['monitor_id'])
            && !$this->db->get_where('monitoring_monitors', array('id' => $data['monitor_id']))->row()) {
            $this->db->trans_rollback();
            return 'Select an existing monitor. The selected monitor may have been deleted.';
        }
        if ($entity === 'section' && $action === 'delete'
            && $this->db->where('section_id', $id)->count_all_results('monitoring_indicators') > 0) {
            $this->db->trans_rollback();
            return 'Move or delete this Domain’s indicators before deleting the Domain.';
        }
        if ($action === 'create') { $this->db->insert($table, $data); }
        elseif ($action === 'update') { $this->db->where('id', $id)->update($table, $data); }
        else { $this->db->where('id', $id)->delete($table); }
        return $this->finish_transaction() ? null : 'The change could not be saved. Please try again.';
    }

    private function finish_transaction()
    {
        if ($this->db->trans_status() === false) { $this->db->trans_rollback(); return false; }
        $this->db->trans_commit();
        return true;
    }
}
