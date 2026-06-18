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

function random_password(){
    $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
    $password = array();
    $alpha_length = strlen($alphabet) - 1;

    for ($i = 0; $i < 10; $i++) {
        $password[] = $alphabet[random_int(0, $alpha_length)];
    }

    return implode($password);
}


public function user_insert(){
    $file = $this->upload->data();
    $filename = $file['file_name']; 
    $division_id = $this->input->post('division_id');

    if (in_array($this->session->position, array('division', 'ict'), true)) {
        $division_id = $this->session->division;
    }

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
    'p_id' => $division_id,
    'd_id' => $this->input->post('d_id'),
    'image' => $filename,
    'virified' => 0
    ); 

    return $this->db->insert('users', $data);
    
}

public function insert_user(){


    $password = $this->input->post('password');
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $data = array(
    'username' => $this->input->post('schoolID'),
    'password' => $hash,
    'position' => 'school',
    'fname' => $this->input->post('schoolName'),
    'r_id' => 12,
    'p_id' => $this->input->post('division_id'),
    'd_id' => $this->input->post('d_id'),
    'email' => $this->input->post('schoolEmail'),
    //'virified' => 1
    'virified' => 0
    ); 

    $this->db->insert('users', $data);
    return $this->db->insert_id();
    
}

public function insert_district_user(){

    $district = $this->Common->one_cond_row('district', 'id',$this->input->post('d_id'));


    $password = $this->input->post('password');
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $data = array(
    'username' => $this->input->post('schoolID'),
    'password' => $hash,
    'position' => 'district',
    'fname' => $district->description,
    'r_id' => 12,
    'p_id' => $this->input->post('division_id'),
    'd_id' => $this->input->post('d_id'),
    'email' => $this->input->post('schoolEmail'),
    //'virified' => 1
    'virified' => 0
    ); 

    $this->db->insert('users', $data);
    return $this->db->insert_id(); 
}

public function confirm_signup(){
    $id = $this->uri->segment(3);
    
    $data = array(
    'virified' => 0
    ); 

    $this->db->where('id', $id);
    return $this->db->update('users', $data);
    
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

public function add_school_user($school_id,$schoolName,$district,$division){


    $password = 'school112';
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $data = array(
    'username' => $school_id,
    'password' => $hash,
    'position' => 'school',
    'fname' => $schoolName,
    'r_id' => 12,
    'p_id' => $division,
    'd_id' => $district,
    'email' => "",
    'virified' => 0
    ); 

    $this->db->insert('users', $data);
    return $this->db->insert_id();
    
}

public function user_password_change(){

    $password = $this->input->post('password');
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $data = array(
    'password' => $hash,
    ); 

    $this->db->where('id', $this->session->id);
    return $this->db->update('users', $data);
    
}

public function division_user_password_change(){

    $password = $this->input->post('password');
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    $data = array(
    'password' => $hash,
    ); 

    $this->db->where('username', $this->input->post('school_id'));
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

public function reset_user_password($id, $password){
    $data = array(
        'password' => password_hash($password, PASSWORD_DEFAULT)
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

public function users_update_profile(){

    $id = $this->session->id;

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
    $this->db->where('virified', 0);
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

public function no_cond_ne($table,$necol,$neval){
    $this->db->where($necol.' !=', $neval);
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

public function district_submission_counts($table, $division, $fy){
    $allowed_tables = array('sgod_action_plan', 'sbm', 'sbm_ta');

    if (!in_array($table, $allowed_tables, true)) {
        return array();
    }

    $this->db->select('district, COUNT(DISTINCT school_id) AS total', false);
    $this->db->where('division', $division);
    $this->db->where('fy', $fy);
    $this->db->group_by('district');
    $query = $this->db->get($table);

    $counts = array();
    foreach ($query->result() as $row) {
        $counts[(string) $row->district] = (int) $row->total;
    }

    return $counts;
}

public function submission_school_ids($table, $fy, $school_ids){
    $allowed_tables = array('sgod_action_plan', 'sbm', 'sbm_ta');

    if (!in_array($table, $allowed_tables, true) || empty($school_ids)) {
        return array();
    }

    $this->db->select('school_id');
    $this->db->distinct();
    $this->db->where('fy', $fy);
    $this->db->where_in('school_id', $school_ids);
    $query = $this->db->get($table);

    $submitted = array();
    foreach ($query->result() as $row) {
        $submitted[(string) $row->school_id] = true;
    }

    return $submitted;
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

public function two_cond_row_select($table,$select, $col, $val,$col2, $val2)
    {
        $this->db->select($select);
        $this->db->where($col, $val);
        $this->db->where($col2, $val2);
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

public function delete_two_cond($table,$col,$val,$col2,$val2){
    $this->db->where($col,$val);
    $this->db->where($col2,$val2);
    $this->db->delete($table);
    return true;
}

function delete_with_attach($table,$segment,$attach){
    $this->db->where('id', $segment);
    $file = "uploads/".$attach;
    if (!empty($attach) && file_exists($file)) {
        unlink($file);
    }
    $this->db->delete($table);
}


// Special query
public function schools_with_district($id)
{
    $this->db->select('a.*, b.description');
    $this->db->from('schools a');
    $this->db->join('district b', 'b.id = a.district_id', 'left');
    $this->db->where('district_id', $id);
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
            'region' => $this->session->region,
            'division' => $this->session->division,
            'district' => $this->session->district,

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
    $data['division'] = $this->session->division;

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

    public function sbm_tana_insert()
	{
		$data = [];

		foreach (['a', 'b', 'c', 'd'] as $prefix) {
			for ($i = 1; $i <= 42; $i++) {
				$data["{$prefix}{$i}"] = $this->input->post("{$prefix}{$i}");
			}
		}

		$data['school_id'] = $this->session->username;
		$data['fy'] = $this->session->fy;
		$data['district'] = $this->session->district;
        $data['region'] = $this->session->region;
        $data['division'] = $this->session->division;
        $data['stat'] = 0;

		return $this->db->insert('tana', $data);
	}

    

	public function sbm_ta_update()
	{
		$data = [];

		foreach (['q', 'qq', 'a', 'f'] as $prefix) {
			for ($i = 1; $i <= 42; $i++) {
				$data["{$prefix}{$i}"] = $this->input->post("{$prefix}{$i}");
			}
		}

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('sbm_ta', $data);
	}

    public function sbm_tana_update()
	{
		$data = [];

		foreach (['a', 'b', 'c', 'd'] as $prefix) {
			for ($i = 1; $i <= 42; $i++) {
				$data["{$prefix}{$i}"] = $this->input->post("{$prefix}{$i}");
			}
		}

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('tana', $data);
	}

    public function sbm_ta_lock_unloc($stat)
	{
		$data = array(
			'stat' => $stat
		);

		$this->db->where('id', $this->uri->segment(3));
		return $this->db->update('sbm_ta', $data);
	}
    
    public function sbm_cecklist_admin_insert()
	{
		$data = [];

		for ($i = 1; $i <= 42; $i++) {
			$data["q$i"] = $this->input->post("r$i");
		}

		for ($i = 1; $i <= 42; $i++) {
			$data["fs$i"] = $this->input->post("fs$i");
		}

		$data['school_id'] = $this->input->post('school_id');
		$data['fy'] = date('Y');

		return $this->db->insert('sbm_remark_admin', $data);
	}

    public function sbm_cecklist_admin_update()
	{
		$data = [];

		for ($i = 1; $i <= 42; $i++) {
			$data["q$i"] = $this->input->post("r$i");
		}

		for ($i = 1; $i <= 42; $i++) {
			$data["fs$i"] = $this->input->post("fs$i");
		}


        $this->db->where('id', $this->input->post('id'));
		return $this->db->update('sbm_remark_admin', $data);
	}

    public function sbm_tech_insert()
	{

		$data = array(
			'ta_rec' => $this->input->post('ta_rec'),
			'sa' => $this->input->post('sa'),
			'cd' => $this->input->post('cd'),
			'mtd' => $this->input->post('mtd'),
			'schedule' => $this->input->post('schedule'),
			'ct' => $this->input->post('ct'),
			'district' => $this->session->district,
			'fy' => date('Y'),

		);

		return $this->db->insert('sbm_tech', $data);
	}

    public function sbm_tech_update()
	{

		$data = array(
			'ta_rec' => $this->input->post('ta_rec'),
			'sa' => $this->input->post('sa'),
			'cd' => $this->input->post('cd'),
			'mtd' => $this->input->post('mtd'),
			'schedule' => $this->input->post('schedule'),
			'ct' => $this->input->post('ct'),
			'district' => $this->session->district,
			'fy' => date('Y'),

		);

        $this->db->where('id', $this->input->post('id'));
		return $this->db->update('sbm_tech', $data);
	}

    public function insert_school()
	{
		$data = array(
			'schoolID' => $this->input->post('schoolID'),
			'schoolName' => $this->input->post('schoolName'),
			'division_id' => $this->input->post('division_id'),
			'district_id' => $this->input->post('d_id'),
            'region_id' => 12,
			'schoolEmail' => $this->input->post('schoolEmail'),
            'schoolType' => $this->input->post('schoolType'),
            'category' => $this->input->post('category'),
            'sgc' => $this->input->post('sgc'),
			'schoolLogo' => 'logo.png'
		);

		return $this->db->insert('schools', $data);
	}

    public function all_fields_positive($id)
    {
        $this->db->from('sbm');
        $this->db->where('id', $id);

        for ($i = 1; $i <= 42; $i++) {
            $this->db->where("q{$i} >", 0);
        }

        $query = $this->db->get();
        return $query->num_rows() > 0; 
    }


    public function get_averages($school_id, $fy) {
        $this->db->where('school_id', $school_id);
        $this->db->where('fy', $fy);
        $query = $this->db->get('tana');

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $averages = [];
            for ($i = 1; $i <= 42; $i++) {
                $a = "a$i";
                $b = "b$i";
                $c = "c$i";
                $d = "d$i";

                $averages[$i] = ($row->$a + $row->$b + $row->$c + $row->$d) / 4;
            }

            return $averages;
        }

        return [];
    }

    public function sbm_tana_summary_insert()
    {
        $concern_id = $this->input->post('concern_id'); 
        $average    = $this->input->post('average');
        $sequence   = $this->input->post('sequence');

        if (!is_array($concern_id) || !is_array($average) || !is_array($sequence)) {
            return 0;
        }

        $fy       = $this->session->fy;
        $school   = $this->session->username;
        $region   = $this->session->region;
        $division = $this->session->division;
        $district = $this->session->district;

        $rows  = [];
        $count = min(count($concern_id), count($average), count($sequence));

        for ($i = 0; $i < $count; $i++) {
            if ($concern_id[$i] === '' || $average[$i] === '' || $average[$i] === null) {
                continue;
            }
            $rows[] = [
                'fy'         => $fy,
                'school_id'  => $school,
                'region'     => $region,
                'division'   => $division,
                'district'   => $district,
                'stat'       => 0,
                'concern_id' => $concern_id[$i],
                'average'    => $average[$i],
                'sequence'   => ($sequence[$i] === '' ? null : (int)$sequence[$i]),
            ];
        }

        if (empty($rows)) return 0;

        $this->db->trans_start();
        $this->db->insert_batch('tana_summary', $rows);
        $this->db->trans_complete();

        return $this->db->trans_status() ? $this->db->affected_rows() : 0;
    }

    public function get_seq_one_two()
    {
        $fy       = $this->session->fy;
        $region   = $this->session->region;
        $division = $this->session->division;

        $select = array(
            'tana_summary.school_id',
            'tana_summary.fy',
            'tana_summary.concern_id',
            'tana_summary.average',
            'tana_summary.sequence'
        );

        for ($i = 1; $i <= 42; $i++) {
            $select[] = 'sbm_ta.q' . $i;
        }

        return $this->db
            ->select(implode(', ', $select))
            ->from('tana_summary')
            ->join(
                'sbm_ta',
                'sbm_ta.school_id = tana_summary.school_id AND sbm_ta.fy = tana_summary.fy',
                'left'
            )
            ->where_in('tana_summary.sequence', [1, 2])
            ->where('tana_summary.fy', $fy)
            ->where('tana_summary.division', $division)
            ->where('tana_summary.region', $region)
            ->order_by('tana_summary.fy', 'ASC')
            ->order_by('tana_summary.school_id', 'ASC')
            ->order_by('tana_summary.sequence', 'ASC')
            ->get()
            ->result();
    }

    public function tana_division_insert(){
            $fy       = $this->session->fy;
            $region   = $this->session->region;
            $division = $this->session->division;
        
            $data = array(
                'tana' => $this->input->post('tana'), 
                'sequence' => $this->input->post('sequence'), 
                'region' => $region,
                'division' => $division, 
                'fy' => $fy
            ); 

        return $this->db->insert('division_tana', $data);
    }

    public function tana_region_insert(){
            $fy       = $this->session->fy;
            $region   = $this->session->region;
            $division = $this->session->division;
        
            $data = array(
                'tana' => $this->input->post('tana'), 
                'sequence' => $this->input->post('sequence'), 
                'region' => $region,
                'fy' => $fy
            ); 

        return $this->db->insert('region_tana', $data);
    }

public function school_updates()
	{

		$data = array(
			'schoolName' => $this->input->post('schoolName'),
            'adminFName' => $this->input->post('adminFName'),
            'adminMName' => $this->input->post('adminMName'),
            'adminLName' => $this->input->post('adminLName'),
            'adminDesignation' => $this->input->post('adminDesignation'),
            'schoolEmail' => $this->input->post('schoolEmail'),
            'adminEmail' => $this->input->post('adminEmail'),
            'adminMobile' => $this->input->post('adminMobile'),
            'sgc' => $this->input->post('sgc'),
            'category' => $this->input->post('category'),
            'schoolType' => $this->input->post('schoolType'),
            'province' => $this->input->post('province'),
            'city' => $this->input->post('city'),
            'brgy' => $this->input->post('brgy'),
            'sitio' => $this->input->post('sitio'),
            'division_id' => $this->input->post('division_id'),
            'district_id' => $this->input->post('d_id'),

		);

		$this->db->where('recID', $this->input->post('recID'));
		return $this->db->update('schools', $data);
}

public function update_district_id()
{
    $tables = ['tana', 'sbm_ta', 'sbm','tana_summary'];

    $this->db->trans_start();

    foreach ($tables as $table) {
        $this->db->where('school_id', $this->session->username);
        $this->db->update($table, [
            'district' => $this->input->post('d_id'),
            'division' => $this->input->post('division')
        ]);
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        return false;
    }

    return true;
}

public function sgc_count($c)
	{
$this->db->where('sgc', $c);
$this->db->where('division_id', $this->session->division);
$this->db->from('schools');
return $this->db->count_all_results();
}

public function sgc_count_region($c)
	{
$this->db->where('sgc', $c);
$this->db->where('region_id', $this->session->region);
$this->db->from('schools');
return $this->db->count_all_results();
}

public function sgc_count_district($c)
	{
$this->db->where('sgc', $c);
$this->db->where('district_id', $this->session->district);
$this->db->from('schools');
return $this->db->count_all_results();
}




public function update_request_password(){
    
    $email = $this->input->post('email');
    $user = $this->Common->one_cond_row('users','email',$email);
        
       
    $password = $this->Page_model->random_password();

    $fname = 'Maam/Sir';

                //Email Notification
                $this->load->config('email');
                $this->load->library('email');
                $mail_message = '
                <!doctype html>
                <html>
                <head>
                  <meta charset="utf-8">
                  <meta name="viewport" content="width=device-width,initial-scale=1">
                </head>
                <body style="margin:0; padding:0; background:#f3f5f7; font-family:Arial, Helvetica, sans-serif;">
                  <div style="padding:24px 12px;">
                    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px; margin:0 auto; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 10px 30px rgba(15,23,42,.10);">
                      
                      <!-- Header -->
                      <tr>
                        <td style="background:linear-gradient(135deg,#a00000,#b90404); padding:22px 26px; color:#ffffff;">
                          <div style="font-size:18px; font-weight:700; letter-spacing:.2px;">DepEd FTAD - Online</div>
                          <div style="font-size:13px; opacity:.95; margin-top:4px;">Password Reset Notification</div>
                        </td>
                      </tr>

                      <!-- Body -->
                      <tr>
                        <td style="padding:26px;">
                          <div style="font-size:15px; color:#111827; line-height:1.6;">
                            <div style="font-size:16px; font-weight:700; margin-bottom:10px;">Dear '.$fname.',</div>

                            <p style="margin:0 0 14px 0;">
                              You have successfully reset your password. Please use the temporary password below to log in.
                            </p>

                            <div style="margin:18px 0; padding:16px; border:1px solid #e5e7eb; border-radius:12px; background:#f9fafb;">
                              <div style="font-size:12px; color:#6b7280; margin-bottom:6px;">Temporary Password</div>
                              <div style="font-size:20px; font-weight:800; color:#dc2626; letter-spacing:.8px;">'.$password.'</div>
                            </div>

                            <p style="margin:0 0 14px 0; color:#374151;">
                              For your security, please change your password immediately after logging in.
                            </p>

                            <div style="margin-top:18px; padding-top:16px; border-top:1px solid #e5e7eb; color:#111827;">
                              <div style="font-weight:700;">Thanks &amp; Regards,</div>
                              <div>DepEd FTAD - Online</div>
                            </div>
                          </div>
                        </td>
                      </tr>

                      <!-- Footer -->
                      <tr>
                        <td style="padding:16px 26px; background:#f9fafb; color:#6b7280; font-size:12px; line-height:1.5;">
                          This email was generated automatically. If you did not request a password reset, please contact your system administrator immediately.
                        </td>
                      </tr>

                    </table>
                  </div>
                </body>
                </html>
                ';

                $this->email->from('no-reply@ftad.depedmis.com', 'FTAD')
                    ->to($email)
                    ->subject('Password Changed')
                    ->message($mail_message);
                $this->email->send();

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $data = array(
        'Password' => $hash

    );

    $this->db->where('email', $email);
    return $this->db->update('users', $data);
}

public function user_updates(){
    $data = array(
        'p_id' => $this->input->post('division_id'),
        'd_id' => $this->input->post('d_id'),
    );

    $this->db->where('username', $this->input->post('schoolID'));
    return $this->db->update('users', $data);
}

public function dd_updates()
{
    $data = [
        'division' => $this->input->post('division_id'),
        'district' => $this->input->post('d_id'),
    ];

    $schoolID = $this->input->post('schoolID');
    $tables = ['sgod_action_plan', 'sbm', 'sbm_ta', 'tana'];

    $this->db->trans_start();

    foreach ($tables as $table) {
        $this->db->where('school_id', $schoolID)->update($table, $data);
    }

    $this->db->trans_complete();

    return $this->db->trans_status();
}

public function tana_summary_del(){
    $this->db->where('school_id',$this->session->username);
    $this->db->delete('tana_summary');
    return true;
}


public function tana_summary_final(){
    $data = array(
        'stat' => 1
    );

    $this->db->where('school_id', $this->session->username);
    return $this->db->update('tana_summary', $data);
}






    












}

