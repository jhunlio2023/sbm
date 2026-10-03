<?php
// Isolated controller checks; no application data is touched.
require __DIR__ . '/monitoring_team_access_test.php';
class SettingsLoader extends MonitorLoader {
    public function view($name, $data = null) { if ($name === 'pages/monitoring_settings') $this->data = $data; }
}
class SettingsDatabase extends AccessDatabase {
    public function query($sql) { return parent::query(str_replace(' FOR UPDATE', '', $sql)); }
}
$db->query('CREATE TABLE monitoring_catalog_state (id INTEGER PRIMARY KEY, seeded INTEGER)');
$db->insert('monitoring_catalog_state', array('id' => 1, 'seeded' => 1));
$db->insert('monitoring_monitors', array('id' => 100, 'first_name' => 'First', 'last_name' => 'Monitor', 'section_unit' => 'Unit'));
$db->insert('monitoring_monitors', array('id' => 101, 'first_name' => 'Second', 'last_name' => 'Monitor', 'section_unit' => 'Unit'));
$page->Monitoring_model->db = new SettingsDatabase($db);
$page->load = new SettingsLoader();
$page->session->position = 'region';
$page->input->method = 'post';
$valid = array('monitoring_token' => 'test-token', 'entity' => 'section', 'action' => 'update', 'id' => '1', 'text' => 'Shared domain', 'sort_order' => '1', 'monitor_ids' => array('100', '101'));
$page->input->post = $valid;
$page->monitoring_settings();
check($page->Monitoring_model->sections()[0]['monitor_ids'] === array(100, 101), 'Controller saves multiple selections');
foreach (array('100', array(array('100')), array('invalid'), array('99999')) as $invalid) {
    $page->input->post = array_merge($valid, array('monitor_ids' => $invalid));
    $page->monitoring_settings();
    check(count($page->load->data['errors']) > 0, 'Reject invalid monitor submission');
    check($page->Monitoring_model->sections()[0]['monitor_ids'] === array(100, 101), 'Invalid POST preserves assignments');
}
$page->input->post = $valid;
unset($page->input->post['monitor_ids']);
$page->monitoring_settings();
check($page->Monitoring_model->sections()[0]['monitor_ids'] === array(), 'Empty selection clears assignments');
echo "Monitoring settings multiple-selection and validation checks passed.\n";
