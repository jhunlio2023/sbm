<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitor_model extends CI_Model
{
    public function initialize()
    {
        $this->db->query(file_get_contents(FCPATH . 'database/monitoring_monitors.sql'));
        if (!$this->db->get_where('position', array('pos' => 'monitoring_team'))->row()) {
            $this->db->insert('position', array('pos' => 'monitoring_team', 'description' => 'Monitoring Team'));
        }
        foreach (array('email' => "VARCHAR(254) NOT NULL DEFAULT ''", 'user_id' => 'INT UNSIGNED NULL DEFAULT NULL') as $column => $type) {
            if (!$this->db->field_exists($column, 'monitoring_monitors')) {
                $this->db->query('ALTER TABLE monitoring_monitors ADD ' . $column . ' ' . $type);
            }
        }
    }

    public function all()
    {
        return $this->db->order_by('last_name')->order_by('first_name')->order_by('id')
            ->get('monitoring_monitors')->result_array();
    }

    public function find($id)
    {
        return $this->db->get_where('monitoring_monitors', array('id' => $id))->row_array();
    }

    public $error = '';

    public function for_user($id)
    {
        $user = $this->db->get_where('users', array('id' => $id, 'position' => 'monitoring_team', 'virified' => 0))->row_array();
        return $user ? $this->db->get_where('monitoring_monitors', array('user_id' => $id))->row_array() : null;
    }

    public function save($id, $data, $password = '')
    {
        $this->error = '';
        $this->db->trans_begin();
        $existing = $id ? $this->find($id) : null;
        if ($id && !$existing) { return $this->fail('This monitor no longer exists.'); }
        $user_id = $existing['user_id'] ?? null;
        $account = $user_id ? $this->db->get_where('users', array('id' => $user_id, 'position' => 'monitoring_team'))->row_array() : null;
        if ($user_id && !$account) { return $this->fail('The linked Monitoring Team account is unavailable.'); }
        $this->db->group_start()->where('email', $data['email'])->or_where('username', $data['email'])->group_end();
        if ($user_id) { $this->db->where('id !=', $user_id); }
        if ($this->db->get('users')->num_rows()) { return $this->fail('This email is already used by another account.'); }
        $user = array('email' => $data['email'], 'fname' => mb_substr($data['first_name'], 0, 45),
            'mname' => mb_substr($data['middle_name'], 0, 45), 'lname' => mb_substr($data['last_name'], 0, 45));
        if ($password !== '') { $user['password'] = password_hash($password, PASSWORD_DEFAULT); }
        if ($user_id) {
            $this->db->where('id', $user_id)->update('users', $user);
        } else {
            if ($password === '') { return $this->fail('Generate a password for the new account.'); }
            $user += array('username' => 'monitor_' . bin2hex(random_bytes(12)), 'position' => 'monitoring_team', 'virified' => 0);
            $this->db->insert('users', $user);
            $user_id = $this->db->insert_id();
        }
        $data['user_id'] = $user_id;
        if ($id) { $this->db->where('id', $id)->update('monitoring_monitors', $data); }
        else { $this->db->insert('monitoring_monitors', $data); }
        if (!$this->db->trans_status()) { return $this->fail('The monitor and account could not be saved.'); }
        $this->db->trans_commit();
        return true;
    }

    private function fail($message)
    {
        $this->error = $message;
        $this->db->trans_rollback();
        return false;
    }

    public function delete($id)
    {
        $this->db->trans_begin();
        $monitor = $this->find($id);
        if (!$monitor) { return $this->fail('This monitor no longer exists.'); }
        if (!empty($monitor['user_id'])) {
            // Disable sign-in while preserving the account identity on saved assessments.
            $this->db->where('id', $monitor['user_id'])->where('position', 'monitoring_team')->update('users', array('virified' => 1));
        }
        $this->db->where('id', $id)->delete('monitoring_monitors');
        if (!$this->db->trans_status()) { return $this->fail('The monitor could not be deleted.'); }
        $this->db->trans_commit();
        return true;
    }
}
