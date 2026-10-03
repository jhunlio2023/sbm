<?php
// Uses the isolated account/controller harness; never connects to application data.
require __DIR__ . '/monitors_test.php';
define('FCPATH', dirname(__DIR__) . '/');
require APPPATH . 'models/Monitoring_model.php';
class AccessCatalog extends Monitoring_model { public function initialize() {} }
class AccessLoader extends MonitorLoader {
    public function view($name, $data = null) { if ($name === 'pages/monitoring_tool') $this->data = $data; }
}
class AccessDatabase {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function query($sql) {
        if (strpos($sql, 'CREATE TABLE IF NOT EXISTS') === 0) return true;
        return $this->db->query($sql);
    }
    public function __call($name, $args) { return call_user_func_array(array($this->db, $name), $args); }
}
function access_status($page, $status, $id = null) {
    try { $page->monitoring_tool($id); } catch (RuntimeException $e) { check($e->getCode() === $status, $e->getMessage()); return; }
    throw new RuntimeException('Expected monitoring status ' . $status);
}
$db = $model->db;
foreach (array(
    'CREATE TABLE monitoring_sections (id INTEGER PRIMARY KEY, title TEXT, sort_order INTEGER, monitor_id INTEGER)',
    'CREATE TABLE monitoring_indicators (id INTEGER PRIMARY KEY, section_id INTEGER, description TEXT, sort_order INTEGER)',
    'CREATE TABLE monitoring_tool_records (id INTEGER PRIMARY KEY AUTOINCREMENT, created_by TEXT, school_name TEXT, school_year TEXT, payload TEXT, created_at TEXT, updated_at TEXT)',
    'CREATE TABLE division (id INTEGER PRIMARY KEY, description TEXT)',
    'CREATE TABLE district (id INTEGER PRIMARY KEY, division_id INTEGER, description TEXT)',
    'CREATE TABLE schools (recID INTEGER PRIMARY KEY, schoolID TEXT, schoolName TEXT, division_id INTEGER, district_id INTEGER)'
) as $sql) { $db->query($sql); }
check($model->save('', array('first_name' => 'Team', 'middle_name' => '', 'last_name' => 'One', 'section_unit' => 'Unit', 'email' => 'team@example.test'), 'Strong-password-123'), 'Create team fixture');
$monitor = $model->all()[0]; $user = $db->get_where('users', array('id' => $monitor['user_id']))->row_array();
$db->insert('monitoring_sections', array('id' => 1, 'title' => 'Assigned', 'sort_order' => 1, 'monitor_id' => $monitor['id']));
$db->insert('monitoring_sections', array('id' => 2, 'title' => 'Private', 'sort_order' => 2, 'monitor_id' => 999));
foreach (array(1, 2) as $group) $db->insert('monitoring_indicators', array('id' => $group, 'section_id' => $group, 'description' => 'Question ' . $group, 'sort_order' => 1));
$db->insert('division', array('id' => 1, 'description' => 'Division'));
$db->insert('district', array('id' => 1, 'division_id' => 1, 'description' => 'District'));
$db->insert('schools', array('recID' => 1, 'schoolID' => 'School', 'schoolName' => 'School', 'division_id' => 1, 'district_id' => 1));
$page->db = new AccessDatabase($db); $page->load = new AccessLoader();
$page->Monitoring_model = new AccessCatalog(); $page->Monitoring_model->db = $db;
$page->session->position = 'monitoring_team'; $page->session->id = $user['id']; $page->session->username = $user['username'];
$page->input->method = 'get'; $page->monitoring_tool();
$display = $page->load->data;
check($display['values']['prepared_by'] === 'Team One', 'Prepared by uses the logged-in account name without an extra space for an empty middle name');
check(count($display['definition']['sections']) === 1 && $display['definition']['sections'][0]['id'] === 1, 'Only assigned indicators are exposed');
$page->input->method = 'post';
$page->input->post = array('monitoring_token' => 'test-token', 'definition_snapshot' => $display['definition_snapshot'], 'definition_signature' => $display['definition_signature'], 'school_year' => '2026-2027', 'division_id' => '1', 'district_id' => '1', 'school_rec_id' => '1', 'answers' => array('yes', 'yes'));
$page->input->post['prepared_by'] = 'Someone Else';
$notes = array('best_practices' => 'Practice one', 'issues_concerns' => 'Concern one', 'action_taken' => 'Action one', 'status_remarks' => 'In progress');
$page->input->post['group_notes'] = array(0 => $notes, 1 => array('best_practices' => 'Unauthorized group'));
$page->monitoring_tool();
$record = $db->get('monitoring_tool_records')->row_array();
check(json_decode($record['payload'], true)['group_notes'] === array($notes), 'Save all four group notes and ignore unassigned groups');
check(json_decode($record['payload'], true)['prepared_by'] === 'Team One', 'Saving ignores a forged Prepared by value');
check($record && count(json_decode($record['payload'], true)['answers']) === 1, 'Save only assigned answers, ignoring extra submitted answers');
$page->input->method = 'get'; $page->monitoring_tool($record['id']);
check($page->load->data['values']['group_notes'][0] === $notes, 'Restore group notes when reopening');
$page->input->method = 'post';
$page->input->post['group_notes'][0]['best_practices'] = str_repeat('x', 5001);
$page->monitoring_tool($record['id']);
check(count($page->load->data['errors']) > 0, 'Reject oversized group notes');
check(json_decode($db->get_where('monitoring_tool_records', array('id' => $record['id']))->row_array()['payload'], true)['group_notes'][0] === $notes, 'Invalid notes do not overwrite saved content');
$page->input->post['group_notes'][0] = $notes;
$page->input->method = 'get';
$db->insert('monitoring_tool_records', array('created_by' => 'someone_else', 'payload' => $record['payload']));
access_status($page, 404, $db->insert_id());
$db->where('id', 1)->update('monitoring_sections', array('monitor_id' => 999));
access_status($page, 403, $record['id']);
$page->input->method = 'post'; access_status($page, 403);
$page->input->method = 'get'; $page->monitoring_tool();
check($page->load->data['definition']['sections'] === array(), 'No assignments gives no indicator access');
$model->delete($monitor['id']); access_status($page, 403);
echo "Monitoring Team filtering, saves, ownership, reassignment, and revoked-account checks passed.\n";
