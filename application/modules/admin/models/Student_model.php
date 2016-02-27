<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Manage Module
 */

class Student_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $student_id = 0;
    public $first_name = null;
    public $last_name = null;
    public $email = null;
    public $active = 1; // default is active(1)
    
    
    public function __construct(){
        parent::__construct();
        $this->db               = & get_instance()->db_mgr;
        $this->load->config('db_constants');
        $this->table            = TBL_STUDENTS;
        $this->address_table    = TBL_ADDRESS;
    }
    public function save(){
        $insert_data = array (
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'admission_number' => $this->admission_number, 
            'admission_date' => $this->admission_date,
            'contact_number1' => $this->contact_number1,
            'contact_number2' => $this->contact_number2,
            'hostal_dayscholor' => $this->hostal_dayscholor,
            'physically_disabled' => $this->physically_disabled,
            'birth_date' => $this->birth_date,
            'disabled_description' => $this->disabled_description,            
            'email' => $this->email,
            'gender' => $this->gender,            
            'active' => $this->active
        );
        $this->db->writer()->insert($this->table,$insert_data);
        $this->student_row_id = $this->db->writer()->insert_id();
        $this->save_candidate_address($this->student_row_id);
        return $this->student_row_id;
    }
    public function save_candidate_address($student_row_id){
        $insert_data_address = array (
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'candidate_type' => '2', //student
            'address_type' => $this->address_type,
            'candidate_id' => $student_row_id
        );
        $this->db->writer()->insert($this->address_table,$insert_data_address);
    }
    public function update() 
    {
        $update_data = array (
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'admission_number' => $this->admission_number,
            'admission_date' => $this->admission_date,
            'contact_number1' => $this->contact_number1,
            'contact_number2' => $this->contact_number2,
            'hostal_dayscholor' => $this->hostal_dayscholor,
            'physically_disabled' => $this->physically_disabled,
            'birth_date' => $this->birth_date,
            'disabled_description' => $this->disabled_description,
            'email' => $this->email,
            'gender' => $this->gender,
            'active' => $this->active
        );
        
        $where = array(
            'student_id' => $this->student_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        $this->update_candidate_address($this->student_id);
        
        return $this->db->writer()->affected_rows();
    }
    public function update_candidate_address($student_row_id){
        $update_data_address = array (
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'candidate_type' => '2', //student
            'address_type' => $this->address_type,
            'candidate_id' => $student_row_id
        );
        $where = array(
            'candidate_id' => $this->student_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->address_table,$update_data_address);
    }
    public function delete() 
    {
        $where = array(
            'student_id' => $this->student_id
        );
        
        $this->db->writer()
                ->where($where)
                ->delete($this->table);
        return $this->db->writer()->affected_rows();
    }
    
    public function get_students($request_data) 
    {
        $students = array();
        
        $columns = array( 
            // datatable column index  => database column name
            0 =>    'admission_number', 
            1 =>    'admission_date', 
            2 =>    'first_name', 
            3 =>    'active',
            4 =>    'last_name',
            5 =>    'email'
        );
        
        
        // get and set the total records count without filter
        $count_query = $this->db->reader()
                        ->select('COUNT(student_id) AS tot_records')
                        ->from($this->table)
                        ->get();
        
        $result_set = $count_query->row();
        $students['total_data'] = $result_set->tot_records;
        $students['total_filtered'] = $students['total_data'];
        
        // get and set the total filtered record counts after applied filter
        if( !empty($request_data['search']['value']) ) 
        {   
            $query = $this->db->reader()
                ->select('COUNT(student_id) AS tot_records')
                ->from($this->table)
                ->where(" first_name LIKE '". $request_data['search']['value'] ."%'")    
                ->get();
            
            $result_set = $count_query->row();
            $students['total_filtered'] = $result_set->tot_records;
            
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where(" first_name LIKE '". $request_data['search']['value'] ."%'")        
                ->order_by($columns[$request_data['order'][0]['column']], $request_data['order'][0]['dir'])
                ->limit($request_data['length'],$request_data['start'])
                ->get();
        } 
        else {
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->order_by($columns[$request_data['order'][0]['column']], $request_data['order'][0]['dir'])
                ->limit($request_data['length'],$request_data['start'])
                ->get();
        }
        
        $students['result'] = $data_query->result();
        return $students;
    }    
    
    public function get_student() 
    {
        $where = array(
            'student_id' => $this->student_id
        );
        
        $query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where($where)
                ->get();
        
        return $query->result();
    }
    public function get_address_book() 
    {
        $where = array(
            'candidate_id' => $this->student_id
        );
        
        $query = $this->db->reader()
                ->select('*')
                ->from($this->address_table)
                ->where($where)
                ->get();
        
        return $query->result();
    }
    public function unique_check() 
    {
        $num_rows = $this->db->reader()
                    ->select('student_id')
                    ->from($this->table)
                    ->where('first_name',$this->first_name)
                    ->where('student_id !=', $this->student_id)
                    ->limit(1)->get()->num_rows();
        if($num_rows)
        {
            return false;
        }
        return true;
    }
    
}