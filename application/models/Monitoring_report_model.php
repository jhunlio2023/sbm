<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Monitoring_report_model extends CI_Model
{
    public function initialize()
    {
        $this->db->query('CREATE TABLE IF NOT EXISTS monitoring_report_settings (region_id INT NOT NULL PRIMARY KEY, letterhead VARCHAR(255) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    }
    public function letterhead($region_id)
    {
        $row = $this->db->get_where('monitoring_report_settings', array('region_id' => (int) $region_id))->row_array();
        return $row ? $row['letterhead'] : '';
    }
    public function set_letterhead($region_id, $path)
    {
        return $this->db->replace('monitoring_report_settings', array('region_id' => (int) $region_id, 'letterhead' => $path));
    }
    public function school_key($record, $values)
    {
        return !empty($values['school_rec_id']) ? 'id:' . $values['school_rec_id']
            : 'name:' . json_encode(array($values['division'] ?? '', $values['district'] ?? '', $record->school_name));
    }
    public function consolidate_division($records, $target, $original)
    {
        $target_values = json_decode($target->payload, true) ?: array();
        $division = trim($target_values['division'] ?? '');
        $schools = array();
        foreach ($records as $record) {
            $values = json_decode($record->payload, true) ?: array();
            if ($record->school_year !== $target->school_year || trim($values['division'] ?? '') !== $division) continue;
            $key = $this->school_key($record, $values);
            if (!isset($schools[$key])) $schools[$key] = array('target' => $record, 'records' => array());
            $schools[$key]['records'][] = $record;
        }
        $domains = array();
        foreach ($schools as $school) {
            $report = $this->consolidate($school['records'], $school['target'], $original);
            foreach ($report['domains'] as $domain) {
                $key = mb_strtolower($domain['title']);
                if (!isset($domains[$key])) $domains[$key] = array('title' => $domain['title'], 'best_practices' => array(), 'issues_concerns' => array(), 'action_taken' => array(), 'status_remarks' => array());
                foreach (array('best_practices', 'issues_concerns', 'action_taken', 'status_remarks') as $field) {
                    foreach ($domain[$field] as $note) {
                        if (!in_array($note, $domains[$key][$field], true)) $domains[$key][$field][] = $note;
                    }
                }
            }
        }
        return array('domains' => array_values($domains), 'school' => array('division' => $division), 'school_count' => count($schools));
    }
    // Records arrive newest first. Keep each author's latest entry for each domain.
    public function consolidate($records, $target, $original)
    {
        $target_values = json_decode($target->payload, true) ?: array();
        $key = $this->school_key($target, $target_values);
        $domains = array(); $seen = array(); $authors = array(); $count = 0;
        foreach ($records as $record) {
            $values = json_decode($record->payload, true) ?: array();
            if ($record->school_year !== $target->school_year || $this->school_key($record, $values) !== $key) continue;
            $used = false;
            foreach (($values['definition'] ?? $original)['sections'] as $index => $section) {
                $title = trim(preg_replace('/^\d+\.\s*/', '', $section['title']));
                $domain_key = mb_strtolower($title);
                $author_key = $record->created_by . ':' . $domain_key;
                if (isset($seen[$author_key])) continue;
                $seen[$author_key] = true; $used = true;
                if (!isset($domains[$domain_key])) $domains[$domain_key] = array('title' => $title, 'best_practices' => array(), 'issues_concerns' => array(), 'action_taken' => array(), 'status_remarks' => array());
                foreach (array('best_practices', 'issues_concerns', 'action_taken', 'status_remarks') as $field) {
                    $note = $values['group_notes'][$index][$field] ?? '';
                    if (is_string($note) && trim($note) !== '' && !in_array(trim($note), $domains[$domain_key][$field], true)) $domains[$domain_key][$field][] = trim($note);
                }
            }
            if ($used) { $count++; $authors[$record->created_by] = trim($values['prepared_by'] ?? '') ?: $record->created_by; }
        }
        return array('domains' => array_values($domains), 'authors' => array_values($authors), 'count' => $count, 'school' => $target_values);
    }
}
