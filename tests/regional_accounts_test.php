<?php
// Isolated SQLite tests, including controller permission checks.
require __DIR__ . '/monitoring_team_access_test.php';
require APPPATH . 'models/Regional_accounts_model.php';
$db->query('ALTER TABLE users ADD r_id INTEGER');
$accounts = new Regional_accounts_model(); $accounts->db = $db;
$profile = array('username' => 'regional_new', 'email' => 'regional@example.test', 'fname' => 'Regional', 'mname' => '', 'lname' => 'User', 'position' => 'region', 'section_unit' => '');
check($accounts->save('', $profile, 'Secure-test-password', 12), 'Create Regional account');
$regional = $db->get_where('users', array('username' => 'regional_new'))->row_array();
check(password_verify('Secure-test-password', $regional['password']), 'Store hashed password');
$team_profile = array_merge($profile, array('username' => 'team_new', 'email' => 'newteam@example.test', 'position' => 'monitoring_team', 'section_unit' => 'Planning'));
check($accounts->save('', $team_profile, 'Secure-test-password', 12), 'Create Monitoring Team account');
$team = $db->get_where('users', array('username' => 'team_new'))->row_array();
$linked = $db->get_where('monitoring_monitors', array('user_id' => $team['id']))->row_array();
check($linked && $linked['section_unit'] === 'Planning', 'Create linked monitor profile');
$team_profile['email'] = 'changed@example.test'; $team_profile['fname'] = 'Updated';
check($accounts->save($team['id'], $team_profile, '', 12), 'Edit team account');
check($db->get_where('monitoring_monitors', array('id' => $linked['id']))->row_array()['email'] === 'changed@example.test', 'Synchronize monitor email');
check($db->get_where('users', array('id' => $team['id']))->row_array()['password'] === $team['password'], 'Profile edit preserves password');
check(!$accounts->save('', $team_profile, 'Secure-test-password', 12), 'Reject duplicate account');
$db->insert('users', array('username' => 'admin_fixture', 'position' => 'admin', 'virified' => 0)); $admin_id = $db->insert_id();
check(!$accounts->find($admin_id), 'Hide out-of-scope accounts');
foreach ($accounts->all() as $row) check(in_array($row['position'], array('region', 'monitoring_team'), true), 'List only permitted levels');
foreach (array('activate', 'deactivate', 'reset', 'delete') as $action) check(!$accounts->change($admin_id, $action, $regional['id'], 'Secure-test-password'), 'Reject out-of-scope ' . $action);
check(!$accounts->save($admin_id, $profile, '', 12), 'Reject out-of-scope edit');
check(!$accounts->save('', array_merge($profile, array('position' => 'admin')), 'Secure-test-password', 12), 'Reject elevated account creation');
check(!$accounts->change($regional['id'], 'delete', $regional['id']), 'Prevent self deletion');
check(!$accounts->change($regional['id'], 'deactivate', $regional['id']), 'Prevent self deactivation');
check($accounts->change($team['id'], 'deactivate', $regional['id']), 'Deactivate account');
check(!$model->for_user($team['id']), 'Deactivated team loses monitoring access');
check($accounts->change($team['id'], 'activate', $regional['id']), 'Activate account');
check((bool) $model->for_user($team['id']), 'Activated team regains assigned access');
check($accounts->change($team['id'], 'reset', $regional['id'], 'Replacement-password-123'), 'Reset password');
check(password_verify('Replacement-password-123', $db->get_where('users', array('id' => $team['id']))->row_array()['password']), 'New password authenticates');
$page->session->position = 'region'; $page->session->id = $regional['id']; $page->session->virified = 0;
$page->session->set_userdata('regional_accounts_token', 'accounts-token');
$page->Regional_accounts_model = $accounts;
$page->input->method = 'post';
$page->input->post = array('action' => 'delete', 'id' => (string) $admin_id, 'regional_accounts_token' => 'accounts-token');
function account_status($page, $status) {
    try { $page->regional_accounts(); } catch (RuntimeException $e) { check($e->getCode() === $status, $e->getMessage()); return; }
    throw new RuntimeException('Expected account status ' . $status);
}
account_status($page, 403);
$page->input->post['id'] = (string) $team['id']; $page->input->post['regional_accounts_token'] = 'invalid'; account_status($page, 403);
$page->input->post['regional_accounts_token'] = 'accounts-token'; $page->session->position = 'monitoring_team'; account_status($page, 403);
$db->where('id', 1)->update('monitoring_sections', array('monitor_id' => $linked['id']));
check($accounts->change($team['id'], 'delete', $regional['id']), 'Delete team account');
check(!$accounts->find($team['id']) && !$model->find($linked['id']), 'Remove linked account and monitor');
check($db->get_where('monitoring_sections', array('id' => 1))->row_array()['monitor_id'] === null, 'Clear deleted monitor assignments');
echo "Regional account management, scope, CSRF, lifecycle, and profile synchronization checks passed.\n";
