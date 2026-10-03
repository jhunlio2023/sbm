<?php
require __DIR__ . '/monitored_schools_access_test.php';
$db->insert('users', array('username' => 'name_fixture', 'fname' => 'Ana', 'mname' => 'Cruz', 'lname' => 'Santos'));
$payload = array('school_rec_id' => '700', 'prepared_by' => 'Old Name');
foreach (array(
    array('name_fixture', '2026-2027', $payload),
    array('name_fixture', '2026-2027', $payload),
    array('deleted_fixture', '2026-2027', array_merge($payload, array('prepared_by' => 'Ben Reyes'))),
    array('other_year', '2025-2026', array_merge($payload, array('prepared_by' => 'Wrong Year'))),
    array('other_school', '2026-2027', array('school_rec_id' => '701', 'prepared_by' => 'Wrong School'))
) as $fixture) {
    $db->insert('monitoring_tool_records', array('created_by' => $fixture[0], 'school_year' => $fixture[1], 'school_name' => 'Name test school', 'payload' => json_encode($fixture[2])));
}
$visible = (object) array('school_name' => 'Name test school', 'school_year' => '2026-2027', 'details' => $payload);
$page->Monitoring_model->add_monitor_names(array($visible));
check($visible->monitor_names === array('Ana Cruz Santos', 'Ben Reyes'), 'Show full account names and saved fallback, deduplicate authors, isolate school and year');
$legacy = (object) array('school_name' => 'Legacy school', 'school_year' => '2026-2027', 'details' => array('division' => 'A', 'district' => 'B'));
foreach (array('B', 'Other district') as $district) {
    $db->insert('monitoring_tool_records', array('created_by' => 'legacy_' . $district, 'school_name' => 'Legacy school', 'school_year' => '2026-2027', 'payload' => json_encode(array('division' => 'A', 'district' => $district, 'prepared_by' => 'Monitor ' . $district))));
}
$page->Monitoring_model->add_monitor_names(array($legacy));
check($legacy->monitor_names === array('Monitor B'), 'Legacy school matching respects district');
echo "Monitor names, multiple contributors, deduplication, fallback, and school/year isolation checks passed.\n";
