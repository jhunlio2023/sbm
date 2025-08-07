<?php


class Pages extends CI_Controller{
    

    public function view(){

        if($this->session->position == 'admin'){
            $page = "dashboard";
            $data['title'] = "Dashboard"; 
        }else{
            $page = "dashboard_school";
            $data['title'] = "Dashboard"; 
        }








            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');
    }


    public function profilelist(){
        
        $page = "profile_list";

        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }

        $data['title'] = "Profile List"; 

        $data['data'] = $this->Page_model->no_cond('profile');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');

    }

    public function qr(){
        
        $page = "qr";

        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }

        $data['title'] = "QR Code"; 

        $data['data'] = $this->Page_model->one_cond_row('profile','id',$this->uri->segment(3));

        $this->load->view('pages/'.$page, $data);

    }

    public function verify(){
        
        $page = "qr_verify";

        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }

        $data['title'] = "QR Code"; 

        $data['data'] = $this->Page_model->one_cond_row('profile','id',$this->uri->segment(3));

        $this->load->view('pages/'.$page, $data);

    }

    public function profile_new(){

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>','</div>');
        $this->form_validation->set_rules('name', 'Fullname', 'required');

        if($this->form_validation->run() == FALSE){

        $page = "profile_add";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $data['title'] = "New Entry"; 
           
            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');

         }else{
            $this->Page_model->profile_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url().'pages/profilelist');
            
        }    
    } 



// user settings area //

    public function userlist(){
        
        $page = "user_list";

        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }

        $data['title'] = "User List"; 

        $data['users'] = $this->Page_model->no_cond('users');

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');

    }

    public function user_new(){

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>','</div>');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        if($this->form_validation->run() == FALSE){

        $page = "user_add";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $data['title'] = "New User"; 
            $data['division'] = $this->Page_model->one_cond('division','region_id',12);
            $data['pos'] = $this->Page_model->no_cond('position');
           
            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');

         }else{
            $fname = $this->input->post('fname');
            $lname = $this->input->post('lname');
            $username = $this->input->post('username');

            $config['allowed_types'] = 'jpg|png';
            $config['upload_path'] = './uploads/';
            $this->load->library('upload', $config);

            $this->upload->do_upload('file');
                $check = $this->Page_model->check_dup_user($fname,$lname,$username);
                if($check->num_rows() >= 1){
                    $this->session->set_flashdata('danger', 'Dubplicate Entry.');
                    redirect(base_url().'pages/user_new');
                }else{
                    $this->Page_model->user_insert();
                    $this->session->set_flashdata('success', 'Successfully saved.');
                    redirect(base_url().'pages/userlist');
                }
           
            
            
        }    
    } 
    public function user_update(){

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>','</div>');
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        if($this->form_validation->run() == FALSE){

        $page = "user_edit";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $data['title'] = "Update User"; 
            $data['data'] = $this->Page_model->one_cond_row('users','id',$this->uri->segment(3));
           
            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');

         }else{

            $this->Page_model->user_update();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url().'pages/userlist');
        }    
    } 

    public function user_delete(){
            $id = $this->uri->segment(3);
            $user = $this->Page_model->one_cond_row('users','id',$id);
            $this->Page_model->delete_with_attach('users',$id,$user->image);
            $this->session->set_flashdata('danger', 'Successfully deleted.');
            redirect(base_url().'pages/userlist'); 
    } 

    public function cp(){
        $this->Page_model->user_pass();
        $this->session->set_flashdata('success', 'Successfully updated.');
        redirect(base_url().'pages/userlist');
      
    } 

    public function profile(){
        $id = $this->input->post('id');
        $user = $this->Page_model->one_cond_row('users','id',$id);
        $config['allowed_types'] = 'jpg|png';
        $config['upload_path'] = './uploads/';
        $this->load->library('upload', $config);

        if($this->upload->do_upload('file')){
            unlink("uploads/".$user->image);
            $this->Page_model->user_update_profile();
            $this->session->set_flashdata('success', 'Successfully updated.');
            redirect(base_url().'pages/userlist');
        }else{
            print_r($this->upload->display_errors()); 
        }
    }

    public function log_in(){

        $this->form_validation->set_error_delimiters('<div class="error">','</div>');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'uassword', 'required');

        if($this->form_validation->run() == FALSE){

            $page = "login";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }
            
            $this->load->view('pages/'.$page);

            }else{

                $user_id = $this->Page_model->login(); 

                if($user_id){

                    $user_data = array(
                        'username' => $user_id['username'],
                        'position' => $user_id['position'],
                        'user' => $user_id['fname'].' '.$user_id['mname'].' '.$user_id['lname'],
                        'region' => $user_id['r_id'],
                        'division' => $user_id['p_id'],
                        'district' => $user_id['d_id'],
                        'logged_in' => true

                    );
                
                    $this->session->set_userdata($user_data);
                    $this->session->set_userdata('fy', date('Y'));
                    $this->session->set_flashdata('user_log', 'You are now loged in as '
                    .$this->session->position);
                    redirect(base_url());
                }else{
                    $this->session->set_flashdata('failed', 'Username/Password not match');
                    redirect(base_url().'log_in');

                }
  

            }
    } 
    public function lock_user_screen(){

        $this->form_validation->set_error_delimiters('<div class="error">','</div>');
        $this->form_validation->set_rules('password', 'password', 'required');

        if($this->form_validation->run() == FALSE){

            $page = "lock_screen";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }
            
            $this->load->view('pages/'.$page);

            }else{

                $user_id = $this->Page_model->lock_screen();

                if($user_id){

                    $user_data = array(
                        'username' => $user_id['username'],
                        'user' => $user_id['fname'].' '.$user_id['mname'].' '.$user_id['lname'],
                        'position' => $user_id['position'],
                        'office' => $user_id['office'],
                        'image' => $user_id['image'],
                        'id' => $user_id['id'],
                        'com_id' => $user_id['company_id'],
                        'logged_in' => true

                    );
                
                    $this->session->set_userdata($user_data);
                    $this->session->set_flashdata('user_log', 'You are now loged in as '
                    .$this->session->position);
                    redirect(base_url());
                }else{
                    $this->session->set_flashdata('failed', 'Password not match');
                    redirect(base_url().'lock_user_screen');

                }
  

            }
    } 
    public function logout(){

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('position');
        $this->session->unset_userdata('office');
        $this->session->unset_userdata('logged_in');

        $this->session->set_flashdata('failed', 'You are logged out.');
        redirect(base_url().'log_in');

    }
    public function lock(){
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('position');
        $this->session->unset_userdata('logged_in');

        $this->session->set_flashdata('danger', 'You are now Lock Screen Mode');
        redirect(base_url().'lock_user_screen');

    }
    
    public function get_provinces() {
        $region_id = $this->input->post('region_id');
        $provinces = $this->db->get_where('province', ['region_id' => $region_id])->result();
        echo json_encode($provinces);
    }

    public function get_districts() {
        $province_id = $this->input->post('province_id');
        $districts = $this->db->get_where('district', ['province_id' => $province_id])->result();
        echo json_encode($districts);
    }

    public function school_list(){
        
        $page = "schools";

        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }

        $data['title'] = "School List"; 

        //$data['data'] = $this->Page_model->one_cond('schools','p_id',$this->session->p_id);
        $data['data'] = $this->Page_model->schools_with_district($this->uri->segment(3));

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');

    }

    public function change_fy() {
        $new_fy = $this->input->post('new_fy');
        if (!empty($new_fy)) {
            $this->session->set_userdata('fy', $new_fy);
        }
        redirect($_SERVER['HTTP_REFERER']); // or redirect('dashboard');
    }

    public function school_new(){  

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>','</div>');
        $this->form_validation->set_rules('schoolID', 'School ID', 'required');

        if($this->form_validation->run() == FALSE){

        $page = "school_add";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $data['title'] = "Add New School"; 
            $data['district'] = $this->Page_model->one_cond('district','province_id',$this->session->p_id);
           
            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');

         }else{

            $this->Page_model->school_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url().'pages/school_list/'.$this->input->post('schoolType'));
        }  
    } 

    public function get_district_by_division() {
        $division_id = $this->input->post('division_id');
        
        $districts = $this->Page_model->get_districts_by_division($division_id);
        echo json_encode($districts);
    }

    function sbm_action_plan()
	    {

        $page = "action_plan_list";

        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }

        $data['title'] = "Action Plan"; 

        $data['data'] = $this->Common->two_cond('sgod_action_plan', 'school_id', $this->session->username, 'fy', $this->session->fy);

        $this->load->view('templates/header_dt');
        $this->load->view('templates/menu');
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/footer_dt');

	}

    
    function sbm_action_plan_pview()
	    {

        $page = "action_plan_pview";

        if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
            show_404();
        }

        $data['title'] = "Action Plan"; 

        $data['school'] = $this->Common->one_cond_row('schools', 'schoolID', $this->session->username);
		$data['data'] = $this->Common->two_cond('sgod_action_plan', 'fy', $this->session->fy, 'school_id', $this->session->username);
        
        $this->load->view('pages/'.$page, $data);

	}

    public function action_plan_new(){

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>','</div>');
        $this->form_validation->set_rules('activity', 'Activity', 'required');

        if($this->form_validation->run() == FALSE){

        $page = "action_plan_new";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $data['title'] = "New Action Plan"; 
           
            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');

         }else{

            $this->Page_model->action_plan_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url().'pages/sbm_action_plan');
        }    
    } 

    public function sbm_action_plan_update(){

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>','</div>');
        $this->form_validation->set_rules('activity', 'Activity', 'required');

        if($this->form_validation->run() == FALSE){

        $page = "action_plan_edit";

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $data['title'] = "New Action Plan"; 
            $data['data'] = $this->Common->one_cond_row('sgod_action_plan', 'id', $this->uri->segment(3));
            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');

         }else{

            $this->Page_model->action_plan_update();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url().'pages/sbm_action_plan');
        }    
    } 

    public function sbm_checklist(){

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>','</div>');

        $this->form_validation->set_rules('district', 'District', 'required');

        if($this->form_validation->run() == FALSE){  

       $data['sbmc'] = $this->Common->two_cond_row('sbm','school_id',$this->session->username,'fy',$this->session->fy);

       $page = !$data['sbmc'] ? 'sbm_form' : 'sbm_form_update';

        

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $data['title'] = "New Action Plan"; 

            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');

         }else{
            $this->Page_model->sbm_checklist_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url().'pages/sbm_checklist');
        }    
    } 

    public function sbm_checklist_update(){
        $this->Page_model->sbm_checklist_update();
        $this->session->set_flashdata('success', 'Successfully saved.');
        redirect(base_url().'pages/sbm_checklist');
    } 
    function sbm_checklist_final(){
		$this->Page_model->sbm_cecklist_lock_unloc(1);
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Pages/sbm_checklist');
	}

    public function tapr_form(){

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>','</div>');

        $this->form_validation->set_rules('district', 'District', 'required');

        if($this->form_validation->run() == FALSE){  

       $data['sbmc'] = $this->Common->two_cond_row('sbm_ta','school_id',$this->session->username,'fy',$this->session->fy);

       $page = !$data['sbmc'] ? 'sbm_ta' : 'sbm_ta_update';

        

            if(!file_exists(APPPATH.'views/pages/'.$page.'.php')){
                show_404();
            }

            $data['title'] = "New Action Plan"; 

            $data['sbm'] = $this->Common->no_cond('sbm_indicator');
            $data['sbm_sub'] = $this->Common->no_cond('sbm_sub_indicator');

            
            $this->load->view('templates/header');
            $this->load->view('templates/menu');
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer');
            $this->load->view('templates/footer_basic');

         }else{
            $this->Page_model->sbm_ta_insert();
            $this->session->set_flashdata('success', 'Successfully saved.');
            redirect(base_url().'pages/tapr_form');
        }    
    } 

    public function tapr_form_update(){
        $this->Page_model->sbm_ta_update();
        $this->session->set_flashdata('success', 'Successfully saved.');
        redirect(base_url().'pages/tapr_form');
    }

    function sbm_ta_final()
	{
		$this->Page_model->sbm_ta_lock_unloc(1);
		$this->session->set_flashdata('success', 'Saved successfully.');
		redirect(base_url() . 'Pages/tapr_form');
	}




    public function action_plan_delete(){
            $this->Page_model->delete('sgod_action_plan','id',3);
            $this->session->set_flashdata('danger', 'Successfully deleted.');
            redirect(base_url().'pages/sbm_action_plan'); 
    } 





   
    

}

?>