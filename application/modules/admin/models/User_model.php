<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : User Management // Institute login
 */

class User_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $user_id = 0;
    public $username = null;
    public $password = null;
    public $first_name = null;
    public $last_name = null;
    public $email = null;
    public $activation_code = null;
    public $created_on = null;
    public $last_login = null;
    public $active = 1; // default is active(1)
    public $institute_id = null;
    
    
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->db = & get_instance()->db_mgr;
       // $this->load->config('db_constants');
        $this->table = TBL_USERS;
    }

    public function save() 
    {
        $insert_data = array (
            'username' => $this->username,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'activation_code' => $this->activation_code,
            'created_on' => 'now()',
            'last_login' => 'now()',
            'active' => $this->active,
            'institute_id' => $this->institute_id
        );
        $this->db->writer()->insert($this->table,$insert_data);
        return $this->db->writer()->insert_id();
    }
    
    public function update() 
    {
        $update_data = array (
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'active' => $this->active,
        );
        
        $where = array(
            'user_id' => $this->user_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        
        return $this->db->writer()->affected_rows();
    }

    public function deactivate() 
    {
        $update_data = array (
            'active' => '1'
        );
        
        $where = array(
            'user_id' => $this->user_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        return $this->db->writer()->affected_rows();
        
    }
    
    public function get_users($request_data) 
    {
        $sections = array();
        
        $columns = array( 
            // datatable column index  => database column name
            0 =>    'first_name', 
            0 =>    'last_name', 
            1 =>    'username', 
            2 =>    'email', 
            3 =>    'created_on', 
            4 =>    'last_login', 
            5 =>    'active'
        );
        
        
        // get and set the total records count without filter
        $count_query = $this->db->reader()
                        ->select('COUNT(user_id) AS tot_records')
                        ->from($this->table)
                        ->where('institute_id', $this->institute_id)
                        ->get();
        
        $result_set = $count_query->row();
        $sections['total_data'] = $result_set->tot_records;
        $sections['total_filtered'] = $sections['total_data'];
        
        // get and set the total filtered record counts after applied filter
        if( !empty($request_data['search']['value']) ) 
        {   
            $query = $this->db->reader()
                ->select('COUNT(user_id) AS tot_records')
                ->from($this->table)
                ->where('institute_id', $this->institute_id)    
                ->where(" username LIKE '". $request_data['search']['value'] ."%'")    
                ->or_where(" first_name LIKE '". $request_data['search']['value'] ."%'")        
                ->or_where(" last_name LIKE '". $request_data['search']['value'] ."%'")            
                ->get();
            
            $result_set = $count_query->row();
            $sections['total_filtered'] = $result_set->tot_records;
            
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where('institute_id', $this->institute_id)    
                ->where(" username LIKE '". $request_data['search']['value'] ."%'")    
                ->or_where(" first_name LIKE '". $request_data['search']['value'] ."%'")        
                ->or_where(" last_name LIKE '". $request_data['search']['value'] ."%'")                  
                ->order_by($columns[$request_data['order'][0]['column']], $request_data['order'][0]['dir'])
                ->limit($request_data['length'],$request_data['start'])
                ->get();
        } 
        else {
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where('institute_id', $this->institute_id)    
                ->order_by($columns[$request_data['order'][0]['column']], $request_data['order'][0]['dir'])
                ->limit($request_data['length'],$request_data['start'])
                ->get();
        }
        
        $sections['result'] = $data_query->result();
        return $sections;
    }    
    
    public function get_user() 
    {
        $where = array(
            'user_id' => $this->user_id
        );
        
        $query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where($where)
                ->get();
        
        return $query->result();
    }
    
    public function unique_check() 
    {
        $num_rows = $this->db->reader()
                    ->select('user_id')
                    ->from($this->table)
                    ->where('institute_id', $this->institute_id)    
                    ->where('username',$this->username)
                    ->where('user_id !=', $this->user_id)
                    ->limit(1)->get()->num_rows();
        if($num_rows)
        {
            return false;
        }
        return true;
    }
    
    
    public function login() {
        $query = $this->db->reader()
                    ->select('user_id,username,password,first_name,last_name,email,last_login')
                    ->from($this->table)
                    ->where('username',$this->username)
                    //->where('password', $this->password)
                    ->where('active', 1)
                    ->where('user_type', 1)
                    ->limit(1)->get();
        if($query->num_rows())
        {
           return $query->result();
        }
        return false;
    }
    
}