<?php


class Pages extends CI_Controller
{

    private function is_user_manager()
    {
        return in_array($this->session->position, array('admin', 'division', 'ict'), true);
    }

    private function is_division_user_manager()
    {
        return in_array($this->session->position, array('division', 'ict'), true);
    }

    private function require_user_manager()
    {
        if (!$this->session->logged_in || !$this->is_user_manager()) {
            show_error('You are not authorized to manage users.', 403);
        }
    }

    private function get_managed_user($id)
    {
        $user = $this->Page_model->one_cond_row('users', 'id', $id);

        if (!$user) {
            show_404();
        }

        if ($this->is_division_user_manager() && (string) $user->p_id !== (string) $this->session->division) {
            show_error('You can only manage users under your division.', 403);
        }

        return $user;
    }

    private function is_allowed_managed_position($position)
    {
        if ($this->session->position === 'admin') {
            return true;
        }

        $position_record = $this->Page_model->one_cond_row('position', 'pos', $position);

        return $position_record && !in_array($position, array('admin', 'region', 'division'), true);
    }

    private function validate_managed_district($district_id)
    {
        if (!$this->is_division_user_manager() || empty($district_id)) {
            return;
        }

        $district = $this->Page_model->one_cond_row('district', 'id', $district_id);

        if (!$district || (string) $district->division_id !== (string) $this->session->division) {
            show_error('The selected district is not under your division.', 403);
        }
    }


    public function view()
    {

        if ($this->session->position == 'admin') {
            $page = "dashboard";
            $data['title'] = "Dashboard";
        } elseif ($this->session->position == 'division') {
            $page = "dashboard_division";
            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

            $data['title'] = "Dashboard";
        } elseif ($this->session->position == 'region') {
            $page = "dashboard_region";
            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

            $data['title'] = "Dashboard";
        } elseif ($this->session->position == 'district') {
            $page = "dashboard_district";
            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

            $data['title'] = "Dashboard";
        } else {
            $page = "dashboard_school";
            $data['title'] = "Dashboard";
        }

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_basic');
    }


    public function profilelist()
    {

        $page = "profile_list";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Profile List";

        $data['data'] = $this->Page_model->no_cond('profile');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function qr()
    {

        $page = "qr";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "QR Code";

        $data['data'] = $this->Page_model->one_cond_row('profile', 'id', $this->uri->segment(3));

        $this->load->view('pages/' . $page, $data);
    }

    public function verify()
    {

        $page = "qr_verify";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "QR Code";

        $data['data'] = $this->Page_model->one_cond_row('profile', 'id', $this->uri->segment(3));

        $this->load->view('pages/' . $page, $data);
    }

    public function profile_new()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('name', 'Fullname', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "profile_add";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New Entry";


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->profile_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/profilelist');
        }
    }



    // user settings area //

    public function userlist()
    {
        $this->require_user_manager();

        if ($this->is_division_user_manager()) {
            redirect(base_url() . 'pages/userlist_division');
        }

        $page = "user_list";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "User List";
        $data['division_scope'] = false;

        $data['users'] = $this->Page_model->no_cond('users');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function userlist_division()
    {
        $this->require_user_manager();

        $page = "user_list";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Division User List";
        $data['division_scope'] = true;

        $data['users'] = $this->Page_model->one_cond('users','p_id',$this->session->division);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function school_by_district()
    {

        $page = "school_list_by_district";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Division List";

        $data['data'] = $this->Common->one_cond_select('division', 'description,id', 'region_id', $this->session->region);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function schools()
    {
        $page = "schools";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";

        $data['data'] = $this->Common->two_join_one_cond_not_gb('schools','district', 'a.recID,id,description,schoolID,schoolName,a.division_id,a.district_id','a.district_id = id', 'a.division_id', $this->uri->segment(3),'schoolName','ASC');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function schools_district()
    {
        $page = "schools";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";

        $data['data'] = $this->Common->two_join_one_cond_not_gb('schools','district', 'a.recID,id,description,schoolID,schoolName,a.division_id,a.district_id','a.district_id = id', 'a.district_id', $this->uri->segment(3),'schoolName','ASC');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function schools_division()
    {
        $page = "schools";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";

        $data['data'] = $this->Common->two_join_one_cond_not_gb('schools','district', 'a.recID,id,description,schoolID,schoolName,a.division_id,a.district_id','a.district_id = id', 'a.division_id', $this->uri->segment(3),'schoolName','ASC');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function sbm_rate_list()
    {
        $page = "sbm_list_rate";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";
        $fy  = $this->session->fy;
        $q   = $this->uri->segment(3);
        $val = $this->uri->segment(4);
        $district = $this->session->district;

        $data['data'] = $this->Common->two_join_three_cond('sbm', 'schools', 'a.school_id, b.schoolID,b.schoolName,a.' .$q, 'a.school_id = b.schoolID', 'fy', $fy, $q, $val, 'district',$district, 'b.schoolName', 'ASC');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function sbm_rate_list_division()
    {
        $page = "sbm_list_rate";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";
        $fy  = $this->session->fy;
        $q   = $this->uri->segment(3);
        $val = $this->uri->segment(4);
        $division = $this->session->division;

        $data['data'] = $this->Common->two_join_three_cond('sbm', 'schools', 'a.school_id, b.division_id, b.schoolID,b.schoolName,a.' .$q, 'a.school_id = b.schoolID', 'fy', $fy, $q, $val, 'division',$division, 'b.schoolName', 'ASC');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function sbm_rate_list_region()
    {
        $page = "sbm_list_rate";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";
        $fy  = $this->session->fy;
        $q   = $this->uri->segment(3);
        $val = $this->uri->segment(4);
        $region = $this->session->region;

        $data['data'] = $this->Common->two_join_three_cond('sbm', 'schools', 'a.school_id, b.schoolID,b.division_id,b.schoolName,a.' .$q, 'a.school_id = b.schoolID', 'fy', $fy, $q, $val, 'region',$region, 'b.schoolName', 'ASC');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function user_new()
    {
        $this->require_user_manager();

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "user_add";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New User";
            $data['division'] = $this->Page_model->one_cond('division', 'region_id', 12);
            if ($this->is_division_user_manager()) {
                $data['pos'] = array_values(array_filter(
                    $this->Page_model->no_cond('position'),
                    function ($position) {
                        return $this->is_allowed_managed_position($position->pos);
                    }
                ));
                $data['districts'] = $this->Page_model->one_cond('district', 'division_id', $this->session->division);
            }else{
                $data['pos'] = $this->Page_model->no_cond('position');  
            }


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $fname = $this->input->post('fname');
            $lname = $this->input->post('lname');
            $username = $this->input->post('username');
            $position = $this->input->post('position');

            if (!$this->is_allowed_managed_position($position)) {
                show_error('You are not authorized to create this type of user.', 403);
            }

            $this->validate_managed_district($this->input->post('d_id'));

            $config['allowed_types'] = 'jpg|png';
            $config['upload_path'] = './uploads/';
            $this->load->library('upload', $config);

            $this->upload->do_upload('file');
            $check = $this->Page_model->check_dup_user($fname, $lname, $username);
            if ($check->num_rows() >= 1) {
                $this->session->set_flashdata('danger', 'Dubplicate Entry.');
                redirect(base_url() . 'pages/user_new');
            } else {
                $this->Page_model->user_insert();
                $this->session->set_flashdata('success', 'Successfully saved.');
                redirect(base_url() . ($this->is_division_user_manager() ? 'pages/userlist_division' : 'pages/userlist'));
            }
        }
    }
    public function user_update()
    {
        $this->require_user_manager();

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "user_edit";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Update User";
            $data['data'] = $this->get_managed_user($this->uri->segment(3));


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->get_managed_user($this->input->post('id'));
            $this->Page_model->user_update();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . ($this->is_division_user_manager() ? 'pages/userlist_division' : 'pages/userlist'));
        }
    }

    public function user_delete()
    {
        $this->require_user_manager();

        $id = $this->uri->segment(3);
        $user = $this->get_managed_user($id);

        if ((string) $user->id === (string) $this->session->id) {
            $this->session->set_flashdata('danger', 'You cannot delete your own account.');
            redirect(base_url() . ($this->is_division_user_manager() ? 'pages/userlist_division' : 'pages/userlist'));
        }

        $this->Page_model->delete_with_attach('users', $id, $user->image);
        $this->session->set_flashdata('danger', 'Successfully deleted.');
        redirect(base_url() . ($this->is_division_user_manager() ? 'pages/userlist_division' : 'pages/userlist'));
    }

    public function school_delete()
    {
        $id = $this->uri->segment(3);
        // $user = $this->Page_model->one_cond_row('users', 'username', $id);
        // $this->Page_model->delete_with_attach('users', $id, $user->image);
        $this->Page_model->delete('schools', 'schoolID', 3);
        $this->Page_model->delete('users', 'username', 3);
        $this->session->set_flashdata('danger', 'Successfully deleted.');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function confirm_signup()
    {

        $user = $this->Page_model->confirm_signup();
        $this->session->set_flashdata('success', 'Successfully Confirmed.');
        redirect(base_url() . 'pages/log_in');
    }

    public function cp()
    {
        $this->require_user_manager();
        $this->get_managed_user($this->input->post('id'));
        $this->Page_model->user_pass();
        $this->session->set_flashdata('success', 'Successfully updated.');
        redirect(base_url() . ($this->is_division_user_manager() ? 'pages/userlist_division' : 'pages/userlist'));
    }

    public function user_reset_password()
    {
        $this->require_user_manager();

        $id = $this->input->post('id');
        $user = $this->get_managed_user($id);
        $password = $this->Page_model->random_password();

        if ($this->Page_model->reset_user_password($id, $password)) {
            $message = 'Password reset for <strong>' . html_escape($user->username)
                . '</strong>. Temporary password: <strong><code>' . html_escape($password) . '</code></strong>';
            $this->session->set_flashdata('success', $message);
        } else {
            $this->session->set_flashdata('danger', 'Unable to reset the password.');
        }

        redirect(base_url() . ($this->is_division_user_manager() ? 'pages/userlist_division' : 'pages/userlist'));
    }

    public function profile()
    {
        if (!$this->session->logged_in || $this->session->position !== 'admin') {
            show_error('You are not authorized to update user profile pictures.', 403);
        }

        $id = $this->input->post('id');
        $user = $this->Page_model->one_cond_row('users', 'id', $id);
        $config['allowed_types'] = 'jpg|png|jpeg|gif|';
        $config['upload_path'] = './uploads/';
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $file = "uploads/" . $user->image;

            if (!empty($user->image) && file_exists($file)) {
                unlink($file);
            }
            $this->Page_model->user_update_profile();
            $this->session->set_flashdata('success', 'Successfully updated.');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            print_r($this->upload->display_errors());
        }
    }

    public function user_profile()
    {
        $id = $this->session->username;
        $user = $this->Page_model->one_cond_row('users', 'username', $id);
        $config['allowed_types'] = 'jpg|png|jpeg|gif|';
        $config['upload_path'] = './uploads/';
        $config['max_size']      = 1024; // 1MB
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $file = "uploads/" . $user->image;

            if (!empty($user->image) && file_exists($file)) {
                unlink($file);
            }
            $this->Page_model->users_update_profile();
            $this->session->set_flashdata('success', 'Successfully updated.');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('danger', $this->upload->display_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function log_in()
    {

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'uassword', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "login";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $this->load->view('pages/' . $page);
        } else {

            $user_id = $this->Page_model->login();

            if ($user_id) {

                $user_data = array(
                    'id' => $user_id['id'],
                    'username' => $user_id['username'],
                    'position' => $user_id['position'],
                    'user' => $user_id['fname'] . ' ' . $user_id['mname'] . ' ' . $user_id['lname'],
                    'region' => $user_id['r_id'],
                    'division' => $user_id['p_id'],
                    'district' => $user_id['d_id'],
                    'virified' => $user_id['virified'],
                    'logged_in' => true

                );

                $this->session->set_userdata($user_data);
                $this->session->set_userdata('fy', date('Y'));
                $this->session->set_flashdata('user_log', 'You are now loged in as '
                    . $this->session->position);
                redirect(base_url());
            } else {
                $this->session->set_flashdata('failed', 'Invalid login. Either your account is not verified (please check your email for the verification link) or your username or password is incorrect.”');
                redirect(base_url() . 'log_in');
            }
        }
    }
    public function lock_user_screen()
    {

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('password', 'password', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "lock_screen";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $this->load->view('pages/' . $page);
        } else {

            $user_id = $this->Page_model->lock_screen();

            if ($user_id) {

                $user_data = array(
                    'username' => $user_id['username'],
                    'user' => $user_id['fname'] . ' ' . $user_id['mname'] . ' ' . $user_id['lname'],
                    'position' => $user_id['position'],
                    'office' => $user_id['office'],
                    'image' => $user_id['image'],
                    'id' => $user_id['id'],
                    'com_id' => $user_id['company_id'],
                    'logged_in' => true

                );

                $this->session->set_userdata($user_data);
                $this->session->set_flashdata('user_log', 'You are now loged in as '
                    . $this->session->position);
                redirect(base_url());
            } else {
                $this->session->set_flashdata('failed', 'Password not match');
                redirect(base_url() . 'lock_user_screen');
            }
        }
    }
    public function logout()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('position');
        $this->session->unset_userdata('office');
        $this->session->unset_userdata('logged_in');

        $this->session->set_flashdata('failed', 'You are logged out.');
        redirect(base_url() . 'log_in');
    }
    public function lock()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('position');
        $this->session->unset_userdata('logged_in');

        $this->session->set_flashdata('danger', 'You are now Lock Screen Mode');
        redirect(base_url() . 'lock_user_screen');
    }

    public function get_provinces()
    {
        $region_id = $this->input->post('region_id');
        $provinces = $this->db->get_where('province', ['region_id' => $region_id])->result();
        echo json_encode($provinces);
    }

    public function get_districts()
    {
        $province_id = $this->input->post('province_id');
        $districts = $this->db->get_where('district', ['province_id' => $province_id])->result();
        echo json_encode($districts);
    }

    public function school_list()
    {

        $page = "district_schools";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";
        $data['division_school_scope'] = false;

        //$data['data'] = $this->Page_model->one_cond('schools','p_id',$this->session->p_id);
        $data['data'] = $this->Common->two_join_two_cond('sbm', 'schools', 'a.school_id,a.district,b.district_id, b.schoolID,b.schoolName,a.fy', 'a.school_id = b.schoolID', 'a.fy', $this->session->fy, 'a.district', $this->session->district, 'b.schoolName', 'ASC');
        $school_ids = array_map(function ($school) {
            return $school->schoolID;
        }, $data['data']);

        $data['submission_status'] = array(
            'sgod_action_plan' => $this->Page_model->submission_school_ids('sgod_action_plan', $this->session->fy, $school_ids),
            'sbm' => $this->Page_model->submission_school_ids('sbm', $this->session->fy, $school_ids),
            'sbm_ta' => $this->Page_model->submission_school_ids('sbm_ta', $this->session->fy, $school_ids)
        );
        $data['district'] = $this->Page_model->one_cond_row('district', 'id', $this->session->district);
        $data['selected_submission'] = 'sbm';

        //$data['data'] = $this->Page_model->schools_with_district($this->session->district);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function school_list_division()
    {

        $page = "district_schools";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";
        $table = $this->uri->segment(4);
        $allowed_tables = array('sgod_action_plan', 'sbm', 'sbm_ta');

        if (!in_array($table, $allowed_tables, true)) {
            show_404();
        }

        //$data['data'] = $this->Page_model->one_cond('schools','p_id',$this->session->p_id);
        //$data['data'] = $this->Page_model->schools_with_district($this->uri->segment(3));
        $data['data'] = $this->Common->two_join_two_cond_gb($table, 'schools', 'a.school_id,a.district,b.district_id, b.schoolID,b.schoolName', 'a.school_id = b.schoolID', 'fy', $this->session->fy, 'a.district', $this->uri->segment(3), 'b.schoolName', 'ASC','a.school_id');
        $school_ids = array_map(function ($school) {
            return $school->schoolID;
        }, $data['data']);

        $data['submission_status'] = array(
            'sgod_action_plan' => $this->Page_model->submission_school_ids('sgod_action_plan', $this->session->fy, $school_ids),
            'sbm' => $this->Page_model->submission_school_ids('sbm', $this->session->fy, $school_ids),
            'sbm_ta' => $this->Page_model->submission_school_ids('sbm_ta', $this->session->fy, $school_ids)
        );
        $data['district'] = $this->Page_model->one_cond_row('district', 'id', $this->uri->segment(3));
        $data['selected_submission'] = $table;
        $data['division_school_scope'] = true;


        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function district_list_division()
    {

        $page = "division_district";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "School List";

        $table = $this->uri->segment(4);

        //$data['data'] = $this->Page_model->one_cond('schools','p_id',$this->session->p_id);
        //$data['data'] = $this->Page_model->schools_with_district($this->uri->segment(3));
        $data['data'] = $this->Common->two_join_two_cond_gb($table, 'schools', 'a.school_id,a.district,b.district_id, b.schoolID,b.schoolName,a.division', 'a.school_id = b.schoolID', 'fy', $this->session->fy, 'a.division', $this->uri->segment(3), 'b.schoolName', 'ASC','a.school_id');


        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function change_fy()
    {
        $new_fy = $this->input->post('new_fy');
        if (!empty($new_fy)) {
            $this->session->set_userdata('fy', $new_fy);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function school_new()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('schoolID', 'School ID', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "school_add";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Add New School";
            $data['district'] = $this->Page_model->one_cond('district', 'division_id', $this->session->p_id);


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {

            $this->Page_model->school_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/school_list/' . $this->input->post('schoolType'));
        }
    }

    public function get_district_by_division()
    {
        $division_id = $this->input->post('division_id');

        $districts = $this->Page_model->get_districts_by_division($division_id);
        echo json_encode($districts);
    }

    function sbm_action_plan()
    {

        $page = "action_plan_list";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Action Plan for Implementation of SBM";

        $data['data'] = $this->Common->two_cond('sgod_action_plan', 'school_id', $this->session->username, 'fy', $this->session->fy);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }


    function sbm_action_plan_pview()
    {

        $page = "action_plan_pview";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Action Plan for Implementation of SBM";

        $data['school'] = $this->Common->one_cond_row('schools', 'schoolID', $this->session->username);
        $data['data'] = $this->Common->two_cond('sgod_action_plan', 'fy', $this->session->fy, 'school_id', $this->session->username);

        $this->load->view('pages/' . $page, $data);
    }

    function sbm_action_plan_pview_district()
    {

        $page = "action_plan_pview";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Action Plan for Implementation of SBM";

        $data['school'] = $this->Common->one_cond_row('schools', 'schoolID', $this->uri->segment(3));
        $data['data'] = $this->Common->two_cond('sgod_action_plan', 'fy', $this->session->fy, 'school_id', $this->uri->segment(3));

        $this->load->view('pages/' . $page, $data);
    }

    public function action_plan_new()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('activity', 'Activity', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "action_plan_new";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New Action Plan for Implementation of SBM";


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {

            $this->Page_model->action_plan_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/sbm_action_plan');
        }
    }

    public function sbm_action_plan_update()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('activity', 'Activity', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "action_plan_edit";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Update Action Plan for Implementation of SBM";
            $data['data'] = $this->Common->one_cond_row('sgod_action_plan', 'id', $this->uri->segment(3));

            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {

            $this->Page_model->action_plan_update();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/sbm_action_plan');
        }
    }

    public function sbm_checklist()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

        $this->form_validation->set_rules('district', 'District', 'required');

        if ($this->form_validation->run() == FALSE) {

            $data['sbmc'] = $this->Common->two_cond_row('sbm', 'school_id', $this->session->username, 'fy', $this->session->fy);

            $page = !$data['sbmc'] ? 'sbm_form' : 'sbm_form_update';



            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New Action Plan";

            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->sbm_checklist_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/sbm_checklist');
        }
    }

    public function checklist_district()
    {


        $data['sbmc'] = $this->Common->two_cond_row('sbm', 'school_id', $this->uri->segment(3), 'fy', $this->session->fy);

        $page = 'sbm_form_update';

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "New Action Plan";

        $data['sbm'] = $this->Common->no_cond('sbm_indicator');
        $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');


        $this->load->view('templates/header');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_basic');
    }

    public function sbm_checklist_update()
    {
        $this->Page_model->sbm_checklist_update();
        $this->session->set_flashdata('success', 'Successfully saved.');
        redirect(base_url() . 'pages/sbm_checklist');
    }
    function sbm_checklist_final()
    {
        $this->Page_model->sbm_cecklist_lock_unloc(1);
        $this->session->set_flashdata('success', 'Saved successfully.');
        redirect(base_url() . 'Pages/sbm_checklist');
    }

    public function tapr_form()
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

        $this->form_validation->set_rules('district', 'District', 'required');

        if ($this->form_validation->run() == FALSE) {

            $data['sbmc'] = $this->Common->two_cond_row('sbm_ta', 'school_id', $this->session->username, 'fy', $this->session->fy);

            $page = !$data['sbmc'] ? 'sbm_ta' : 'sbm_ta_update';



            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Technical Assistance Needs Assessment Form";

            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->sbm_ta_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/tapr_form');
        }
    }

    public function tapr_form_update()
    {
        $this->Page_model->sbm_ta_update();
        $this->session->set_flashdata('success', 'Successfully saved.');
        redirect(base_url() . 'pages/tapr_form');
    }

    public function tana_form()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

        $this->form_validation->set_rules('district', 'District', 'required');

        if ($this->form_validation->run() == FALSE) {

            $data['tana'] = $this->Common->two_cond_row('tana', 'school_id', $this->session->username, 'fy', $this->session->fy);

            $page = !$data['tana'] ? 'sbm_tana' : 'sbm_tana_update';



            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Technical Assistance Needs Assessment Form";

            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->sbm_tana_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/tana_form');
        }
    }

    public function tana_summary()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

        $this->form_validation->set_rules('district', 'District', 'required');

        if ($this->form_validation->run() == FALSE) {

            //$data['tana'] = $this->Common->two_cond_row('tana', 'school_id', $this->session->username, 'fy', $this->session->fy);
            //$data['indicator'] = $this->Common->no_cond('sbm_sub_indicator');

            $page = 'sbm_tana_top_list';



            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Technical Assistance Needs Assessment Priority Basis";

            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

            $averages = $this->Page_model->get_averages($this->session->username, $this->session->fy);
            arsort($averages);

            // Keep only top 20
            $top20 = array_slice($averages, 0, 20, true);

            $data['averages'] = $top20;


            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->sbm_tana_summary_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/tana_summary');
        }
    }

    public function tana_summary_division()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

        $this->form_validation->set_rules('district', 'District', 'required');

        if ($this->form_validation->run() == FALSE) {

            //$data['tana'] = $this->Common->two_cond_row('tana', 'school_id', $this->session->username, 'fy', $this->session->fy);
            //$data['indicator'] = $this->Common->no_cond('sbm_sub_indicator');

            $page = 'sbm_tana_top_list_division';



            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Technical Assistance Needs Assessment Priority Basis";
            $data['data'] = $this->Page_model->get_seq_one_two();
            $data['ivy'] = $this->Common->two_cond_order_by('division_tana','fy',$this->session->fy,'division',$this->session->division,'sequence','ASC');



            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->sbm_tana_summary_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/tana_summary');
        }
    }

    public function tana_summary_region()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

        $this->form_validation->set_rules('district', 'District', 'required');

        if ($this->form_validation->run() == FALSE) {

            //$data['tana'] = $this->Common->two_cond_row('tana', 'school_id', $this->session->username, 'fy', $this->session->fy);
            //$data['indicator'] = $this->Common->no_cond('sbm_sub_indicator');

            $page = 'tana_region';



            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Technical Assistance Needs Assessment Priority Basis";
            $data['data'] = $this->Page_model->two_cond('division_tana','region',$this->session->region, 'fy', $this->session->fy);
            $data['ivy'] = $this->Common->two_cond_order_by('region_tana','fy',$this->session->fy,'region',$this->session->region,'sequence','ASC');



            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->sbm_tana_summary_region_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/tana_summary');
        }
    }

    public function tana_summary_update()
    {
        $this->Page_model->delete_two_cond('tana_summary','fy',$this->session->fy,'school_id',$this->session->username);
        $this->Page_model->sbm_tana_summary_insert();
        $this->session->set_flashdata('success', 'Successfully saved.');
        redirect(base_url() . 'pages/tana_summary');
    }

    public function tana_division()
    {
        $this->Page_model->tana_division_insert();
        $this->session->set_flashdata('success', 'Successfully saved.');
        redirect(base_url() . 'pages/tana_summary_division');
    }

    public function tana_region()
    {
        $this->Page_model->tana_region_insert();
        $this->session->set_flashdata('success', 'Successfully saved.');
        redirect(base_url() . 'pages/tana_summary_region');
    }

    public function tana_form_update()
    {
        $this->Page_model->sbm_tana_update();
        $this->session->set_flashdata('success', 'Successfully saved.');
        redirect(base_url() . 'pages/tana_form');
    }

    function sbm_ta_final()
    {
        $this->Page_model->sbm_ta_lock_unloc(1);
        $this->session->set_flashdata('success', 'Saved successfully.');
        redirect(base_url() . 'Pages/tapr_form');
    }





    public function action_plan_delete()
    {
        $this->Page_model->delete('sgod_action_plan', 'id', 3);
        $this->session->set_flashdata('danger', 'Successfully deleted.');
        redirect(base_url() . 'pages/sbm_action_plan');
    }

    public function tapr_form_district()
    {
        if ($this->form_validation->run() == FALSE) {

            $data['sbm_remark'] = $this->Common->two_cond_row('sbm_remark_admin', 'school_id', $this->uri->segment(3), 'fy', $this->session->fy);

            $page = !$data['sbm_remark'] ? 'sbm_ta_district' : 'sbm_ta_district_update';

            //$page = 'sbm_ta_district';

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "New Action Plan";

            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');
            $data['sbmc_count'] = $this->Common->two_cond_count_row('sbm_ta', 'school_id', $this->uri->segment(3), 'fy', $this->session->fy);
            $data['sbmc'] = $this->Common->two_cond_row('sbm_ta', 'school_id', $this->uri->segment(3), 'fy', $this->session->fy);

            //$data['lock'] = $this->Common->three_cond_count_row('sbm_ta', 'school_id', $this->uri->segment(3), 'fy', $this->session->fy,'stat',1);



            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        }
    }

    function tapr_admin()
    {
        $this->Page_model->sbm_cecklist_admin_insert();
        $this->session->set_flashdata('success', 'Saved successfully.');
        redirect(base_url() . 'Pages/tapr_form_district/' . $this->input->post('school_id'));
    }
    function tapr_district_update()
    {
        $this->Page_model->sbm_cecklist_admin_update();
        $this->session->set_flashdata('success', 'Saved successfully.');
        redirect(base_url() . 'Pages/tapr_form_district/' . $this->input->post('school_id'));
    }


    public function sbm_district_tech()
    {

        $page = 'sbm_district_tech';

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Technical Assisstance Provision Form";

        $data['data'] = $this->Common->two_cond('sbm_tech', 'district', $this->session->district, 'fy', $this->session->fy);


        $this->load->view('templates/header');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_basic');
    }

    public function sbm_district_tech_new()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

        $this->form_validation->set_rules('ta_rec', 'Technical Assisstance', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = 'sbm_district_tech_new';

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }


            $data['title'] = "Technical Assisstance Provision Form";

            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->sbm_tech_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/sbm_district_tech');
        }
    }

    public function sbm_district_tech_edit()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');

        $this->form_validation->set_rules('ta_rec', 'Technical Assisstance', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = 'sbm_district_tech_update';

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['data'] = $this->Common->one_cond_row('sbm_tech', 'id', $this->uri->segment(3));
            $data['title'] = "New Action Plan";

            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {
            $this->Page_model->sbm_tech_update();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'pages/sbm_district_tech');
        }
    }

    public function sbm_district_tech_del()
    {
        $this->Page_model->delete('sbm_tech', 'id', 3);
        $this->session->set_flashdata('danger', 'Successfully deleted.');
        redirect(base_url() . 'pages/sbm_district_tech');
    }



    // function sbm_list()
    // {
    // 	$_SESSION['sbm_fy'] = $this->input->post('fy');
    // 	$result['title'] = "SCHOOL-BASED FEEDING PROGRAM";
    // 	$result['sbm'] = $this->Common->no_cond('sbm_indicator');
    // 	$result['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

    // 	$sbm = $this->Common->one_cond_count_row('sbm', 'school_id', $this->uri->segment(3));
    // 	$result['sbmc'] = $this->Common->one_cond_row('sbm', 'school_id', $this->uri->segment(3));

    // 	$result['sbmcr'] = $this->Common->one_cond_row('sbm_remark', 'school_id', $this->uri->segment(3));
    // 	$sbmr = $this->Common->one_cond_count_row('sbm_remark', 'school_id', $this->uri->segment(3));


    // 	$this->load->view('sbm_list', $result);
    // }

    public function sbm_list()
    {

        $page = 'sbm_list';

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Technical Assisstance Provision Form";

        $data['sbm'] = $this->Common->no_cond('sbm_indicator');
        $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

        $data['data'] = $this->Common->two_cond('sbm_tech', 'district', $this->session->district, 'fy', $this->session->fy);


        $this->load->view('templates/header');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_basic');
    }

    public function district_list()
    {

        $page = "district";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "List Of District";

        //$data['data'] = $this->Page_model->one_cond('schools','p_id',$this->session->p_id);
        $data['data'] = $this->Page_model->one_cond('district', 'division_id', $this->session->division);
        $data['submission_counts'] = array(
            'sgod_action_plan' => $this->Page_model->district_submission_counts(
                'sgod_action_plan',
                $this->session->division,
                $this->session->fy
            ),
            'sbm' => $this->Page_model->district_submission_counts(
                'sbm',
                $this->session->division,
                $this->session->fy
            ),
            'sbm_ta' => $this->Page_model->district_submission_counts(
                'sbm_ta',
                $this->session->division,
                $this->session->fy
            )
        );

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function division_list()
    {

        $page = "division";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Division List";

        //$data['data'] = $this->Page_model->one_cond('schools','p_id',$this->session->p_id);
        $data['data'] = $this->Page_model->one_cond('division', 'region_id', 12);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    public function sbm_rate_divisions_list()
    {

        $page = "sbm_rate_division_list";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Division List";

        //$data['data'] = $this->Page_model->one_cond('schools','p_id',$this->session->p_id);
        $data['data'] = $this->Page_model->one_cond('division', 'region_id', 12);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    // public function signup(){

    //     $page = "school_signup";

    //     if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
    //         show_404();
    //     }

    //     $data['title'] = "Division List"; 

    //     //$data['data'] = $this->Page_model->one_cond('schools','p_id',$this->session->p_id);
    //     $data['division'] = $this->Page_model->one_cond('division','region_id',12);

    //     $this->load->view('pages/'.$page, $data);

    // }

    public function signup()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        ', '</div>');
        $this->form_validation->set_rules('schoolName', 'school Name', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "school_signup";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }
            $data['division'] = $this->Page_model->one_cond('division', 'region_id', 12);


            $this->load->view('pages/' . $page, $data);
            } else {

                $recaptcha = $this->input->post('g-recaptcha-response');
                $secret = trim('6LedsqorAAAAAJLksDbaUK9OIhlM-6bNeR52eXbo');

                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptcha}");
                $responseKeys = json_decode($response, true);

                if (!$responseKeys["success"]) {
                    $this->session->set_flashdata('danger', 'reCAPTCHA verification failed. Please try again.');
                    redirect(base_url() . 'log_in');
                }


            $renren = $this->input->post('renren');
            $ivykate = $this->input->post('ivykate');
            $ivankyle = $this->input->post('ivankyle');
            $ic = $this->input->post('ic');

            $schoolID = $this->input->post('schoolID');
            $user_email = $this->input->post('schoolEmail');

            if (!empty($renren) || !empty($ivykate) || !empty($ivankyle) || !empty($ic)) {
                $this->session->set_flashdata('danger', 'I Got you');
                redirect(base_url() . 'private');
            }

            $check = $this->Common->one_cond_count_row('schools', 'schoolID', $schoolID)->num_rows();
            $user_check = $this->Common->one_cond_count_row('users', 'email', $user_email)->num_rows();

            if ($check == 0 && $user_check == 0) {
                $this->Page_model->insert_school();
                $this->Page_model->insert_user();
                $pass = base_url() . 'Pages/confirm_signup/' . $this->db->insert_id();
            } else {
                $this->session->set_flashdata('failed', 'Duplicate entry found. The record already exists.');
                redirect(base_url() . 'log_in');
            }

            $email = $this->input->post('schoolEmail');
            $name = $this->input->post('schoolName');
            $username = $this->input->post('schoolID');
            $pn = $this->input->post('password');
            

            //Email Notification
            $this->load->config('email');
            $this->load->library('email');
            $mail_message = '
                    <html>
                    <head>
                    <style>
                        body {
                        font-family: "Segoe UI", Roboto, Arial, sans-serif;
                        background-color: #f0f4f8;
                        margin: 0;
                        padding: 20px;
                        }
                        .email-wrapper {
                        max-width: 600px;
                        margin: auto;
                        background-color: #ffffff;
                        border-radius: 10px;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                        overflow: hidden;
                        }
                        .email-header {
                        background-color: #a00000;
                        color: white;
                        padding: 20px;
                        text-align: center;
                        }
                        .email-header h2 {
                        margin: 0;
                        font-size: 24px;
                        }
                        .email-body {
                        padding: 30px 25px;
                        color: #333333;
                        }
                        .email-body p {
                        font-size: 16px;
                        line-height: 1.6;
                        }
                        .credentials-box {
                        background-color: #e9f2ff;
                        padding: 15px;
                        border-left: 4px solid #a00000;
                        margin: 20px 0;
                        border-radius: 6px;
                        }
                        .credentials-box p {
                        margin: 0;
                        font-weight: bold;
                        color: #a00000;
                        }
                        .email-footer {
                        background-color: #f7f7f7;
                        padding: 15px;
                        text-align: center;
                        font-size: 14px;
                        color: #666666;
                        }
                        .cb{
                            margin-top:20px;
                            background-color:#a00000;
                            color:#ffffff !important;
                            padding:7px 15px;
                            text-decoration:none;
                            border-radius:6px;
                            font-size:16px;
                            font-weight:bold;
                            display:inline-block;
                        }
                    </style>
                    </head>
                    <body>
                    <div class="email-wrapper">
                        <div class="email-header">
                        <h2>Welcome to FTAD OneView</h2>
                        </div>
                        <div class="email-body">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>Your profile has been successfully encoded into the <strong>FTAD OneView</strong> system. Please find your login credentials below:</p>

                        <div class="credentials-box">
                            <p>Username: ' . htmlspecialchars($username) . '</p>
                            <p>Password: ' . htmlspecialchars($pn) . '</p>
                            <a class="cb" href="' . htmlspecialchars($pass) . '">' . 'Confirm' . '</a>
                        </div>

                        <p>Kindly keep this information secure and do not share it with anyone.</p>
                        <p>Should you have any issues accessing your account, please contact your system administrator.</p>

                        <p style="margin-top: 30px;">Thanks & Regards,<br><strong>FTAD OneView Team</strong></p>
                        </div>
                        <div class="email-footer">
                        © ' . date('Y') . ' Department of Education
                        </div>
                    </div>
                    </body>
                    </html>';

            $this->email->from('no-reply@lxeinfotechsolutions.com', 'FTAD OneView Team')
                ->to($email)
                ->subject('Account Created')
                ->message($mail_message);
            $this->email->send();

            //$this->session->set_flashdata('success', 'School account has been registered successfully. Your username and password have been sent to your email.');
            $this->session->set_flashdata('success', 'The school account has been successfully registered. You may now sign in using your credentials.');
            redirect(base_url() . 'log_in');
        }
    }


    public function signup_district()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        ', '</div>');
        $this->form_validation->set_rules('schoolID', 'Username', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "district_signup";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }
            $data['division'] = $this->Page_model->one_cond('division', 'region_id', 12);


            $this->load->view('pages/' . $page, $data);
            } else {

                $recaptcha = $this->input->post('g-recaptcha-response');
                $secret = trim('6LedsqorAAAAAJLksDbaUK9OIhlM-6bNeR52eXbo');

                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptcha}");
                $responseKeys = json_decode($response, true);

                if (!$responseKeys["success"]) {
                    $this->session->set_flashdata('danger', 'reCAPTCHA verification failed. Please try again.');
                    redirect(base_url() . 'log_in');
                }


            $renren = $this->input->post('renren');
            $ivykate = $this->input->post('ivykate');
            $ivankyle = $this->input->post('ivankyle');
            $ic = $this->input->post('ic');

            $districtID = $this->input->post('d_id');
            $username = $this->input->post('schoolID');

            if (!empty($renren) || !empty($ivykate) || !empty($ivankyle) || !empty($ic)) {
                $this->session->set_flashdata('danger', 'I Got you');
                redirect(base_url() . 'private');
            }

            $user = $this->Common->one_cond_count_row('users', 'username', $username)->num_rows();

            if ($user > 0) { 
                $this->session->set_flashdata('failed', 'Duplicate entry found. The record already exists.');
                redirect(base_url('log_in'));
            }

            $check = $this->Common->two_cond_count_row('users', 'd_id', $districtID,'position','district')->num_rows();

            if ($check == 0) {
                $this->Page_model->insert_district_user(); 
                $pass = base_url() . 'Pages/confirm_signup/' . $this->db->insert_id();
            } else {
                $this->session->set_flashdata('failed', 'Duplicate entry found. The record already exists.');
                redirect(base_url() . 'log_in');
            }

            $district = $this->Common->one_cond_row('district', 'id',$this->input->post('d_id'));

            $email = $this->input->post('schoolEmail');
            $name = $district->description;
            $username = $this->input->post('schoolID');
            $pn = $this->input->post('password');
            

            //Email Notification
            $this->load->config('email');
            $this->load->library('email');
            $mail_message = '
                    <html>
                    <head>
                    <style>
                        body {
                        font-family: "Segoe UI", Roboto, Arial, sans-serif;
                        background-color: #f0f4f8;
                        margin: 0;
                        padding: 20px;
                        }
                        .email-wrapper {
                        max-width: 600px;
                        margin: auto;
                        background-color: #ffffff;
                        border-radius: 10px;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                        overflow: hidden;
                        }
                        .email-header {
                        background-color: #a00000;
                        color: white;
                        padding: 20px;
                        text-align: center;
                        }
                        .email-header h2 {
                        margin: 0;
                        font-size: 24px;
                        }
                        .email-body {
                        padding: 30px 25px;
                        color: #333333;
                        }
                        .email-body p {
                        font-size: 16px;
                        line-height: 1.6;
                        }
                        .credentials-box {
                        background-color: #e9f2ff;
                        padding: 15px;
                        border-left: 4px solid #a00000;
                        margin: 20px 0;
                        border-radius: 6px;
                        }
                        .credentials-box p {
                        margin: 0;
                        font-weight: bold;
                        color: #a00000;
                        }
                        .email-footer {
                        background-color: #f7f7f7;
                        padding: 15px;
                        text-align: center;
                        font-size: 14px;
                        color: #666666;
                        }
                        .cb{
                            margin-top:20px;
                            background-color:#a00000;
                            color:#ffffff !important;
                            padding:7px 15px;
                            text-decoration:none;
                            border-radius:6px;
                            font-size:16px;
                            font-weight:bold;
                            display:inline-block;
                        }
                    </style>
                    </head>
                    <body>
                    <div class="email-wrapper">
                        <div class="email-header">
                        <h2>Welcome to FTAD OneView</h2>
                        </div>
                        <div class="email-body">
                        <p>Dear ' . htmlspecialchars($name) . ',</p>
                        <p>Your profile has been successfully encoded into the <strong>FTAD OneView</strong> system. Please find your login credentials below:</p>

                        <div class="credentials-box">
                            <p>Username: ' . htmlspecialchars($username) . '</p>
                            <p>Password: ' . htmlspecialchars($pn) . '</p>
                            <a class="cb" href="' . htmlspecialchars($pass) . '">' . 'Confirm' . '</a>
                        </div>

                        <p>Kindly keep this information secure and do not share it with anyone.</p>
                        <p>Should you have any issues accessing your account, please contact your system administrator.</p>

                        <p style="margin-top: 30px;">Thanks & Regards,<br><strong>FTAD OneView Team</strong></p>
                        </div>
                        <div class="email-footer">
                        © ' . date('Y') . ' Department of Education
                        </div>
                    </div>
                    </body>
                    </html>';

            $this->email->from('no-reply@lxeinfotechsolutions.com', 'FTAD OneView Team')
                ->to($email)
                ->subject('Account Created')
                ->message($mail_message);
            $this->email->send();

            //$this->session->set_flashdata('success', 'School account has been registered successfully. Your username and password have been sent to your email.');
            $this->session->set_flashdata('success', 'The district account has been successfully registered. You may now sign in using your credentials.');
            redirect(base_url() . 'log_in');
        }
    }


    function school()
    {

        $page = "school_info";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Action Plan";

        $data['data'] = $this->Common->one_cond_row('schools', 'schoolID', $this->uri->segment(2));


        $this->load->view('templates/header');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_basic');
    }

    


    function homepage()
    {

        $page = "home";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }
        $data['title'] = "Homepage";
        $this->load->view('templates/css_homepage');
        $this->load->view('templates/nav');
        $this->load->view($page, $data);
    }

    function authors()
    {

        $page = "authors";
        $this->load->view('templates/css_author');
        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }
        $data['title'] = "Authors";
        $this->load->view('templates/nav');
        $this->load->view($page, $data);
    }

    function about()
    {

        $page = "about";

        if (!file_exists(APPPATH . 'views/' . $page . '.php')) {
            show_404();
        }
        $data['title'] = "About";
        $this->load->view('templates/css_about');
        $this->load->view('templates/nav');
        $this->load->view($page, $data);
    }

    public function tana_division_delete()
    {
        $this->Page_model->delete('division_tana', 'id', 3);
        $this->session->set_flashdata('danger', 'Successfully deleted.');
        redirect(base_url() . 'pages/tana_summary_division');
    }

    public function tana_region_delete()
    {
        $this->Page_model->delete('region_tana', 'id', 3);
        $this->session->set_flashdata('danger', 'Successfully deleted.');
        redirect(base_url() . 'pages/tana_summary_region');
    }

    public function forgot_password()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        ', '</div>');
        $this->form_validation->set_rules('email', 'Email', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "fp";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $this->load->view('pages/' . $page);
        } else {
            
            $email_check = $this->Common->one_cond_count_row('users', 'email', $this->input->post('email'));
            
            if ($email_check->num_rows() == 0) {
                $this->session->set_flashdata('failed', 'We could not find your email address.');
                redirect(base_url() . 'Pages/forgot_password');
            } else {
                $this->Page_model->update_request_password();
                $this->session->set_flashdata('success', 'The new password has been sent to your email.');

                redirect(base_url() . 'log_in');
            }
        }
    }

    public function school_update()
    {

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>', '</div>');
        $this->form_validation->set_rules('schoolName', 'School Name', 'required');

        if ($this->form_validation->run() == FALSE) {

            $page = "school_update";

            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = "Update Action Plan for Implementation of SBM";
            $data['data'] = $this->Common->one_cond_row('schools', 'recID', $this->uri->segment(3));
            $data['division'] = $this->Page_model->one_cond('division', 'region_id', 12);
            $data['districts'] = $this->Page_model->get_districts_by_division($data['data']->division_id);

            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
        } else {

            $this->Page_model->school_updates();
            $this->Page_model->update_district_id();
            $this->Page_model->user_updates();
            $this->Page_model->dd_updates();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url() . 'school/'. $this->session->username);
        }
    }

    public function district_account()
    {

        $page = "district_list_division";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "Profile List";

        $data['district'] = $this->Page_model->one_cond('district','division_id',$this->session->division);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    function sbm_checklist_unlock()
	{
		$this->Page_model->sbm_cecklist_lock_unloc(0);
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect($_SERVER['HTTP_REFERER']);
	}

    public function district_userlist_by_division()
    {

        $page = "user_list";

        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        $data['title'] = "User List";
        $id = $this->uri->segment(3);

        $data['users'] = $this->Page_model->two_cond('users','position','district','d_id',$id);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');
    }

    function sbm_ta_unlock()
	{
		$this->Page_model->sbm_ta_lock_unloc(0);
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect($_SERVER['HTTP_REFERER']);
	}

    function update_tana_summary()
	{
		$this->Page_model->tana_summary_del();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect($_SERVER['HTTP_REFERER']);
	}

    function final_tana_summary()
	{
		$this->Page_model->tana_summary_final();
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect($_SERVER['HTTP_REFERER']);
	}

     function change_password_user()
	{
		$this->Page_model->user_password_change();
		$this->session->set_flashdata('success', 'Password successfully changed.');
		redirect($_SERVER['HTTP_REFERER']);
	}

    function change_password_user_division()
	{
		$this->Page_model->division_user_password_change();
		$this->session->set_flashdata('success', 'Password successfully changed.');
		redirect($_SERVER['HTTP_REFERER']);
	}

    function add_school_user()
	{
        $schoolName = rawurldecode($this->uri->segment(4));
        $school_id = $this->uri->segment(3);
        $district = $this->uri->segment(5);
        $division = $this->uri->segment(6);
        
		$this->Page_model->add_school_user($school_id,$schoolName,$district,$division);
		$this->session->set_flashdata('success', 'Password successfully changed.');
		redirect($_SERVER['HTTP_REFERER']);
	}
    





















}
