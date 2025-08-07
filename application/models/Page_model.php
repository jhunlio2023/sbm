<?php


class Page_model extends CI_Model{

    public function __construct(){
        $this->load->database();

    }


public function profile_insert(){
    
    $data = array(
        'name' => $this->input->post('name'), 
        'docType' => $this->input->post('docType'), 
        'docNo' => $this->input->post('docNo'), 
        'dateReleased' => $this->input->post('dateReleased'), 
        'description' => $this->input->post('description')
    ); 

    return $this->db->insert('profile', $data);
    
}


public function user_insert(){
    $file = $this->upload->data();
    $filename = $file['file_name']; 

    $password = $this->input->post('password');
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $data = array(
    'username' => $this->input->post('username'),
    'password' => $hash,
    'position' => $this->input->post('position'),
    'fname' => $this->input->post('fname'),
    'mname' => $this->input->post('mname'),
    'lname' => $this->input->post('lname'),
    'gender' => $this->input->post('gender'),
    'r_id' => $this->session->region,
    'p_id' => $this->input->post('division_id'),
    'd_id' => $this->input->post('d_id'),
    'image' => $filename
    ); 

    return $this->db->insert('users', $data);
    
}

public function user_update(){

    $id = $this->input->post('id'); 

    $data = array(
        'fname' => $this->input->post('fname'),
        'mname' => $this->input->post('mname'),
        'lname' => $this->input->post('lname'),
        'gender' => $this->input->post('gender')
        );

    $this->db->where('id', $id);
    return $this->db->update('users', $data);
}
public function user_pass(){

    $id = $this->input->post('id'); 

    $password = $this->input->post('password');
    $hash = password_hash($password, PASSWORD_DEFAULT);


    $data = array(
        'password' => $hash,
        );

    $this->db->where('id', $id);
    return $this->db->update('users', $data);
}
public function user_update_profile(){

    $id = $this->input->post('id');

    $file = $this->upload->data();
    $filename = $file['file_name']; 

    $data = array(
        'image' => $filename
        );

    $this->db->where('id', $id);
    return $this->db->update('users', $data);
}

public function login(){

    $password = $this->input->post('password');
    
    $this->db->where('username', $this->input->post('username', true));
    //$this->db->where('status', 0);
    //$this->db->where('Password', $this->input->post('Password', true));
    $result = $this->db->get('users');

    if($result->num_rows() == 1){
      
        $data = $result->row(); 

       if (password_verify($password, $data->password)) {
            return $result->row_array();
       }

       // return $result->row_array();
        
    }else{
        return false;
    }

}
public function lock_screen(){

    $password = $this->input->post('password');
    
    $this->db->where('username', $this->session->username);
    //$this->db->where('status', 0);
    //$this->db->where('Password', $this->input->post('Password', true));
    $result = $this->db->get('users');

    if($result->num_rows() == 1){
      
        $data = $result->row(); 

       if (password_verify($password, $data->password)) {
            return $result->row_array();
       }

       // return $result->row_array();
        
    }else{
        return false;
    }

}

public function check_dup_user($fname,$lname,$username){
    $result = $this->db->where("fname",$fname);
    $result = $this->db->where('lname',$lname);
    $result = $this->db->or_where('username',$username);
    $result = $this->db->get('users');
    return $result;
}


public function school_insert(){
    
    $data = array(
    'schoolID' => $this->input->post('schoolID'), 
    'schoolName' => $this->input->post('schoolName'), 
    'course' => $this->input->post('course'), 
    'yearEstab' => $this->input->post('yearEstab'), 
    'schoolEmail' => $this->input->post('schoolEmail'), 
    'congDist' => $this->input->post('congDist'), 
    'province' => $this->input->post('province'), 
    'city' => $this->input->post('city'), 
    'brgy' => $this->input->post('brgy'), 
    'sitio' => $this->input->post('sitio'), 
    'adminFName' => $this->input->post('adminFName'), 
    'adminMName' => $this->input->post('adminMName'), 
    'adminLName' => $this->input->post('adminLName'), 
    'adminMobile' => $this->input->post('adminMobile'), 
    'adminTel' => $this->input->post('adminTel'), 
    'adminEmail' => $this->input->post('adminEmail'), 
    'adminDesignation' => $this->input->post('adminDesignation'), 
    'permitNo' => $this->input->post('permitNo'), 
    //'recogNo' => $this->input->post('recogNo'), 
    //'offers' => $this->input->post('offers'), 
    //'schoolLogo' => $this->input->post('schoolLogo'), 
    //'type' => $this->input->post('type'), 
    'electricity' => $this->input->post('electricity'), 
    'internet' => $this->input->post('internet'), 
    'mb' => $this->input->post('mb'), 
    'provider' => $this->input->post('provider'), 
    'coor' => $this->input->post('coor'), 
    'r_id' => $this->session->r_id, 
    'p_id' => $this->session->p_id, 
    'd_id' => $this->input->post('district'), 
    'schoolType' => $this->input->post('schoolType'),
    'sitio' => '',
    'adminTel' => ''
    ); 

    return $this->db->insert('schools', $data);
    
}



// common functions loop

public function no_cond($table){
    $query = $this->db->get($table);
    return $query->result();
}

public function one_cond($table,$col,$val){
    $this->db->where($col, $val);
    $query = $this->db->get($table);
    return $query->result();
}

public function two_cond($table,$col,$val,$col2,$val2){
    $this->db->where($col, $val);
    $this->db->where($col2, $val2);
    $query = $this->db->get($table);
    return $query->result();
}
public function three_cond($table,$col,$val,$col2,$val2,$col3,$val3){
    $this->db->where($col, $val);
    $this->db->where($col2, $val2);
    $this->db->where($col3, $val3);
    $query = $this->db->get($table);
    return $query->result();
}

public function one_cond_loop_order_by($table,$col,$val,$orderby,$orderbyvalue){
    $this->db->where($col, $val);
    $this->db->order_by($orderby, $orderbyvalue);
    $query = $this->db->get($table);
    return $query->result();
}


// common function single row
public function one_cond_row($table, $col, $val){
    $this->db->where($col, $val);
    $result = $this->db->get($table)->row();
    return $result;
}


//common function

public function delete($table,$col_id,$segment){
    $id = $this->uri->segment($segment);
    $this->db->where($col_id,$id);
    $this->db->delete($table);
    return true;
}

function delete_with_attach($table,$segment,$attach){
    $this->db->where('id', $segment);
    unlink("uploads/".$attach);
    $this->db->delete($table);
}


// Special query
public function schools_with_district($type)
{
    $this->db->select('a.*, b.description');
    $this->db->from('schools a');
    $this->db->join('district b', 'b.id = a.d_id', 'left');
    $this->db->where('schoolType', $type);
    $query = $this->db->get();
    return $query->result();
}


public function get_districts_by_division($division_id) {
    return $this->db->get_where('district', ['division_id' => $division_id])->result();
}

public function action_plan_insert()
	{
		$data = array(
			'activity' => $this->input->post('activity'),
			'objective' => $this->input->post('objective'),
			'ex_output' => $this->input->post('ex_output'),
			'metho_strategy' => $this->input->post('metho_strategy'),
			'time_frame' => $this->input->post('time_frame'),
			'person_involved' => $this->input->post('person_involved'),
			'bud_req' => $this->input->post('bud_req'),
			'remarks' => $this->input->post('remarks'),
			'fy' => $this->session->fy,
			'school_id' => $this->session->username,
            'region_id' => $this->session->region,
            'division_id' => $this->session->division,
            'district_id' => $this->session->district,

		);

		return $this->db->insert('sgod_action_plan', $data);
}

public function action_plan_update()
	{

		$data = array(
			'activity' => $this->input->post('activity'),
			'objective' => $this->input->post('objective'),
			'ex_output' => $this->input->post('ex_output'),
			'metho_strategy' => $this->input->post('metho_strategy'),
			'time_frame' => $this->input->post('time_frame'),
			'person_involved' => $this->input->post('person_involved'),
			'bud_req' => $this->input->post('bud_req'),
			'remarks' => $this->input->post('remarks'),

		);

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('sgod_action_plan', $data);
}

public function sbm_checklist_insert()
{
    $data = [];

    // Loop through q1 to q42
    for ($i = 1; $i <= 42; $i++) {
        $data["q$i"] = $this->input->post("q$i");
    }

    // Add fixed values
    $data['school_id'] = $this->session->username;
    $data['fy'] = $this->session->fy;
    $data['district'] = $this->input->post('district');
    $data['region'] = $this->session->region;

    return $this->db->insert('sbm', $data);
}

public function sbm_checklist_update()
{
    $data = [];

    // Loop through q1 to q42
    for ($i = 1; $i <= 42; $i++) {
        $data["q$i"] = $this->input->post("q$i");
    }


   $this->db->where('id', $this->input->post('id'));
   return $this->db->update('sbm', $data);
}

public function sbm_cecklist_lock_unloc($stat){
	$data = array(
		'stat' => $stat
	);

	$this->db->where('id', $this->uri->segment(3));
	return $this->db->update('sbm', $data);
}

public function sbm_ta_insert()
	{
		$data = [];

		// Collect data for 'q', 'qq', 'a', and 'f' fields
		foreach (['q', 'qq', 'a', 'f'] as $prefix) {
			for ($i = 1; $i <= 42; $i++) {
				$data["{$prefix}{$i}"] = $this->input->post("{$prefix}{$i}");
			}
		}

		// Add additional fields
		$data['school_id'] = $this->session->username;
		$data['fy'] = $this->session->fy;
		$data['district'] = $this->session->district;
        $data['region'] = $this->session->region;
        $data['division'] = $this->session->division;
        $data['stat'] = 0;

		return $this->db->insert('sbm_ta', $data);
	}

	public function sbm_ta_update()
	{
		$data = [];

		// Collect data for 'q', 'qq', 'a', and 'f' fields
		foreach (['q', 'qq', 'a', 'f'] as $prefix) {
			for ($i = 1; $i <= 42; $i++) {
				$data["{$prefix}{$i}"] = $this->input->post("{$prefix}{$i}");
			}
		}

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('sbm_ta', $data);
	}

    public function sbm_ta_lock_unloc($stat)
	{
		$data = array(
			'stat' => $stat
		);

		$this->db->where('id', $this->uri->segment(3));
		return $this->db->update('sbm_ta', $data);
	}












}

