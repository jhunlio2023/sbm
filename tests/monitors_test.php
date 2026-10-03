<?php
// Run: php -n tests/monitors_test.php. Uses an isolated in-memory database.
error_reporting(E_ALL & ~E_DEPRECATED);
define('BASEPATH', dirname(__DIR__) . '/system/');
define('APPPATH', dirname(__DIR__) . '/application/');
function log_message($level, $message) {}
function show_error($message, $status = 500) { throw new RuntimeException($message, $status); }
function show_404() { throw new RuntimeException('Not found', 404); }
function redirect($url) {}
class CI_Model { public $db; }
class CI_Controller { public $session, $input, $load, $Monitor_model; public function __construct() { $this->session = new MonitorSession(); } }
require BASEPATH . 'database/DB.php';
require APPPATH . 'models/Monitor_model.php';
require APPPATH . 'controllers/Pages.php';
class TestMonitorModel extends Monitor_model { public function initialize() {} }
class MonitorSession {
    public $logged_in = true, $position = 'region', $virified = 0, $id = null, $region = 12;
    private $data = array('monitoring_token' => 'test-token');
    public function userdata($key) { return $this->data[$key] ?? null; }
    public function set_userdata($key, $value) { $this->data[$key] = $value; }
    public function set_flashdata($key, $value) { $this->data[$key] = $value; }
}
class MonitorInput {
    public $post = array(), $get = array(), $method = 'post';
    public function method() { return $this->method; }
    public function post($key) { return $this->post[$key] ?? null; }
    public function get($key) { return $this->get[$key] ?? null; }
}
class MonitorLoader {
    public $data;
    public function model($name) {}
    public function view($name, $data = null) { if ($name === 'pages/monitors') $this->data = $data; }
}
function check($condition, $message) { if (!$condition) throw new RuntimeException($message); }
function expect_status($page, $status) {
    try { $page->monitors(); } catch (RuntimeException $e) { check($e->getCode() === $status, $e->getMessage()); return; }
    throw new RuntimeException('Expected status ' . $status);
}
$model = new TestMonitorModel();
$model->db = DB(array('dbdriver' => 'sqlite3', 'database' => ':memory:', 'db_debug' => true));
$model->db->query("CREATE TABLE monitoring_monitors (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name TEXT NOT NULL, middle_name TEXT NOT NULL DEFAULT '', last_name TEXT NOT NULL, section_unit TEXT NOT NULL, email TEXT, user_id INTEGER)");
$model->db->query("CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, email TEXT, password TEXT, position TEXT, virified INTEGER, fname TEXT, mname TEXT, lname TEXT)");
$page = new Pages();
$page->session = new MonitorSession(); $page->input = new MonitorInput(); $page->load = new MonitorLoader(); $page->Monitor_model = $model;
$valid = array('action' => 'create', 'monitoring_token' => 'test-token', 'first_name' => ' Ana ', 'middle_name' => '', 'last_name' => "O'Neil", 'section_unit' => 'Quality Assurance', 'email' => 'ana@example.test', 'account_password' => 'Test-password-123');
$page->input->post = $valid; $page->monitors();
$rows = $model->all(); check(count($rows) === 1 && $rows[0]['first_name'] === 'Ana' && $rows[0]['middle_name'] === '', 'Create and trim with optional middle name');
$id = (string) $rows[0]['id'];
$account = $model->db->get_where('users', array('id' => $rows[0]['user_id']))->row_array();
check($account['position'] === 'monitoring_team' && password_verify($valid['account_password'], $account['password']), 'Create linked account with hashed password');
check($model->for_user($account['id'])['id'] == $id, 'Resolve logged-in user to monitor');
$page->input->post = array_merge($valid, array('first_name' => 'Duplicate'));
$page->monitors(); check(count($model->all()) === 1, 'Reject duplicate email without orphan monitor');
$page->input->post = array_merge($valid, array('action' => 'update', 'id' => $id, 'middle_name' => 'Cruz', 'section_unit' => 'Planning', 'email' => 'ana.updated@example.test', 'account_password' => ''));
$page->monitors(); check($model->find($id)['section_unit'] === 'Planning' && count($model->all()) === 1, 'Update existing monitor');
check($model->db->get_where('users', array('id' => $account['id']))->row_array()['password'] === $account['password'], 'Blank password preserves stored hash');
check($model->db->get_where('users', array('id' => $account['id']))->row_array()['email'] === 'ana.updated@example.test', 'Editing monitor synchronizes account email');
$page->input->method = 'get'; $page->input->get = array('edit' => (string) $id); $page->monitors();
check($page->load->data['form']['middle_name'] === 'Cruz', 'Edit loads stored data');
$page->input->method = 'post'; $page->input->get = array();
foreach (array('first_name' => ' ', 'last_name' => '', 'section_unit' => '', 'middle_name' => str_repeat('a', 101)) as $field => $value) {
    $page->input->post = array_merge($valid, array($field => $value)); $page->monitors();
    check(count($model->all()) === 1 && count($page->load->data['errors']) > 0, 'Reject invalid ' . $field);
}
$page->input->post = array_merge($valid, array('monitoring_token' => 'bad')); expect_status($page, 403);
$page->input->post = $valid; $page->session->position = 'school'; expect_status($page, 403);
$page->session->position = 'region'; $page->session->logged_in = false; expect_status($page, 403);
$page->session->logged_in = true; $page->session->virified = 1; expect_status($page, 403); $page->session->virified = 0;
$page->input->post = array_merge($valid, array('action' => 'delete', 'id' => array('1'))); expect_status($page, 400);
$page->input->post = array_merge($valid, array('action' => 'update', 'id' => '999')); expect_status($page, 404);
$page->input->post = array_merge($valid, array('action' => 'delete', 'id' => (string) $id)); $page->monitors();
check(count($model->all()) === 0, 'Delete monitor');
check(!$model->for_user($account['id']), 'Deleted monitor loses access');
check($model->db->get_where('users', array('id' => $account['id']))->row_array()['virified'] == 1, 'Deleted monitor account is disabled');
echo "Monitors CRUD, validation, token, and access checks passed.\n";
