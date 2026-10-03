<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regional_accounts_model extends CI_Model
{
    public $error = '';
    private $roles = array('region', 'monitoring_team');

    public function all()
    {
        return $this->db->select('id, username, email, fname, mname, lname, position, virified')
            ->where_in('position', $this->roles)->order_by('position')->order_by('lname')->order_by('fname')->get('users')->result_array();
    }

    public function find($id)
    {
        $user = $this->db->select('id, username, email, fname, mname, lname, position, virified')
            ->where_in('position', $this->roles)->get_where('users', array('id' => $id))->row_array();
        if ($user) {
            $monitor = $this->db->get_where('monitoring_monitors', array('user_id' => $id))->row_array();
            $user['section_unit'] = $monitor ? $monitor['section_unit'] : '';
        }
        return $user;
    }

    public function save($id, $data, $password, $region_id)
    {
        $this->error = '';
        $this->db->trans_begin();
        $existing = $id ? $this->find($id) : null;
        if (($id && !$existing) || !in_array($data['position'], $this->roles, true)) {
            return $this->fail('This account is outside your permitted account levels.');
        }
        if ($existing && $existing['position'] !== $data['position']) {
            return $this->fail('An existing account’s level cannot be changed here.');
        }
        // Keep usernames stable because saved assessments use them as their owner.
        $username = $existing ? $existing['username'] : $data['username'];
        $this->db->group_start()->where('email', $data['email'])->or_where('username', $data['email'])
            ->or_where('username', $username)->or_where('email', $username)->group_end();
        if ($id) { $this->db->where('id !=', $id); }
        if ($this->db->get('users')->num_rows()) { return $this->fail('The email address or username is already used by another account.'); }
        if (!$existing && $this->db->where('created_by', $username)->count_all_results('monitoring_tool_records') > 0) {
            return $this->fail('This username belongs to saved assessments. Choose a different username.');
        }
        $user = array('fname' => $data['fname'], 'mname' => $data['mname'], 'lname' => $data['lname'], 'email' => $data['email']);
        if (!$existing) {
            if (strlen($password) < 12) { return $this->fail('A password of at least 12 characters is required.'); }
            $user += array('username' => $username, 'position' => $data['position'], 'virified' => 0, 'r_id' => $region_id);
            $user['password'] = password_hash($password, PASSWORD_DEFAULT);
            $this->db->insert('users', $user);
            $id = $this->db->insert_id();
        } else { $this->db->where('id', $id)->where_in('position', $this->roles)->update('users', $user); }
        if ($data['position'] === 'monitoring_team') {
            $monitor = $this->db->get_where('monitoring_monitors', array('user_id' => $id))->row_array();
            $profile = array('first_name' => $data['fname'], 'middle_name' => $data['mname'], 'last_name' => $data['lname'],
                'email' => $data['email'], 'section_unit' => $data['section_unit'], 'user_id' => $id);
            if ($monitor) { $this->db->where('id', $monitor['id'])->update('monitoring_monitors', $profile); }
            else { $this->db->insert('monitoring_monitors', $profile); }
        }
        return $this->finish();
    }

    public function change($id, $action, $actor_id, $password = null)
    {
        $this->error = '';
        $this->db->trans_begin();
        if (!$this->find($id)) { return $this->fail('This account is outside your permitted account levels.'); }
        if (!in_array($action, array('activate', 'deactivate', 'delete', 'reset'), true)) { return $this->fail('Invalid account action.'); }
        if ((string) $id === (string) $actor_id && in_array($action, array('deactivate', 'delete'), true)) {
            return $this->fail('You cannot deactivate or delete your own account.');
        }
        if ($action === 'activate') {
            $account = $this->find($id);
            if ($account['position'] === 'monitoring_team' && !$this->db->get_where('monitoring_monitors', array('user_id' => $id))->row()) {
                return $this->fail('Edit and save this account to restore its monitor profile before activating it.');
            }
        }
        if ($action === 'delete') {
            $monitor = $this->db->get_where('monitoring_monitors', array('user_id' => $id))->row_array();
            if ($monitor) {
                $this->db->where('monitor_id', $monitor['id'])->update('monitoring_sections', array('monitor_id' => null));
                $this->db->where('id', $monitor['id'])->delete('monitoring_monitors');
            }
            $this->db->where('id', $id)->where_in('position', $this->roles)->delete('users');
        } else {
            if ($action === 'reset' && (!is_string($password) || strlen($password) < 12)) { return $this->fail('A secure password is required.'); }
            $data = $action === 'reset' ? array('password' => password_hash($password, PASSWORD_DEFAULT)) : array('virified' => $action === 'activate' ? 0 : 1);
            $this->db->where('id', $id)->where_in('position', $this->roles)->update('users', $data);
        }
        return $this->finish();
    }

    private function fail($message)
    {
        $this->error = $message;
        $this->db->trans_rollback();
        return false;
    }

    private function finish()
    {
        if (!$this->db->trans_status()) { return $this->fail('The account change could not be saved.'); }
        $this->db->trans_commit();
        return true;
    }
}
