<?php
define('BASEPATH', __DIR__);
class CI_Model {}
require dirname(__DIR__) . '/application/models/Monitoring_report_model.php';
function report_record($id, $author, $school, $year, $note, $title = '1. Curriculum') {
    return (object) array('id' => $id, 'created_by' => $author, 'school_name' => 'School', 'school_year' => $year,
        'payload' => json_encode(array('school_rec_id' => $school, 'prepared_by' => $author, 'definition' => array('sections' => array(array('title' => $title, 'items' => array()))), 'group_notes' => array(array('best_practices' => $note)))));
}
function check($value, $message) { if (!$value) throw new RuntimeException($message); }
$m = new Monitoring_report_model();
$latest = report_record(5, 'A', 1, '2026-2027', 'Latest');
$records = array($latest, report_record(4, 'B', 1, '2026-2027', 'Other monitor', '2. Curriculum'), report_record(3, 'A', 1, '2026-2027', 'Old'), report_record(2, 'C', 2, '2026-2027', 'Wrong school'), report_record(1, 'A', 1, '2025-2026', 'Wrong year'));
$r = $m->consolidate($records, $latest, array('sections' => array()));
check(count($r['domains']) === 1, 'Merge the same domain despite different numbering');
check($r['domains'][0]['best_practices'] === array('Latest', 'Other monitor'), 'Use latest entries and isolate school/year');
check($r['authors'] === array('A', 'B'), 'Include contributing preparers');
check($r['domains'][0]['status_remarks'] === array(), 'Missing notes remain empty');
$records[1] = report_record(4, 'B', 1, '2026-2027', 'Latest');
check(count($m->consolidate($records, $latest, array())['domains'][0]['best_practices']) === 1, 'Deduplicate identical notes');
echo "Consolidation, school/year isolation, latest-entry selection, and missing-note checks passed.\n";
