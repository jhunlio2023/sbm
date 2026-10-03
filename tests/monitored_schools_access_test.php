<?php
// Isolated database fixtures; no application records are touched.
require __DIR__ . '/monitoring_team_access_test.php';
class DirectoryLoader extends MonitorLoader {
    public function view($name, $data = null) { if ($name === 'pages/monitored_schools') $this->data = $data; }
}
function directory_status($page, $status, $id = null) {
    try { $page->monitored_schools($id); }
    catch (RuntimeException $e) { check($e->getCode() === $status, $e->getMessage()); return; }
    throw new RuntimeException('Expected directory status ' . $status);
}
check($model->save('', array('first_name' => 'Directory', 'middle_name' => '', 'last_name' => 'Monitor', 'section_unit' => 'Unit', 'email' => 'directory@example.test'), 'Strong-password-123'), 'Create active directory user');
$active = $model->all()[0];
$account = $db->get_where('users', array('id' => $active['user_id']))->row_array();
$page->session->id = $account['id']; $page->session->username = $account['username'];
$page->session->position = 'monitoring_team'; $page->session->logged_in = true; $page->session->virified = 0;
$page->load = new DirectoryLoader(); $page->input->method = 'get';
$page->monitored_schools();
check($page->load->data['records'] === array() && $page->load->data['school_count'] === 0, 'New monitor sees empty directory');
$db->insert('monitoring_tool_records', array('created_by' => $account['username'], 'school_name' => 'Own school', 'school_year' => '2026-2027', 'payload' => $record['payload']));
$own_id = $db->insert_id();
$page->monitored_schools();
check(count($page->load->data['records']) === 1 && $page->load->data['records'][0]->id == $own_id, 'Team list includes only owned assessments');
check($page->load->data['school_count'] === 1 && $page->load->data['complete'] === 1, 'Summary counts only owned records');
$page->monitored_schools((string) $own_id);
check($page->load->data['detail'], 'Team can view own details');
$page->input->get = array('print' => '1'); $page->monitored_schools((string) $own_id);
check(count($page->load->data['records']) === 1, 'Team can print own details');
directory_status($page, 404, (string) $record['id']);
directory_status($page, 404, 'invalid');
$page->session->position = 'region'; $page->monitored_schools();
check(count($page->load->data['records']) === 3, 'Regional directory retains all records');
$page->session->position = 'school'; directory_status($page, 403);
$page->session->position = 'monitoring_team'; $page->session->logged_in = false; directory_status($page, 403);
$page->session->logged_in = true; $page->session->virified = 1; directory_status($page, 403);
$page->session->virified = 0;
$db->where('id', $account['id'])->update('users', array('virified' => 1)); directory_status($page, 403);
$model->delete($active['id']); directory_status($page, 403);
echo "Monitored Schools ownership, summaries, details, printing, and access checks passed.\n";
