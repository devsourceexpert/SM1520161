<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Manage Module
 */

class Parents_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $parent_id = 0;
    public $first_name = null;
    public $last_name = null;
    public $email = null;
    public $active = 1; // default is active(1)
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->db = & get_instance()->db_mgr;
        $this->load->config('db_constants');
        $this->table = TBL_PARENTS;
        $this->address_table = TBL_ADDRESS;
    }

    public function save() 
    {
        $insert_data = array (
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'contact_number1' => $this->contact_number1,
            'contact_number2' => $this->contact_number2,
            'primary_account' => $this->primary_account,
            'relationship' => $this->relationship,
            'email' => $this->email,
            'active' => $this->active
        );
        $this->db->writer()->insert($this->table,$insert_data);
        $this->parent_row_id = $this->db->writer()->insert_id();
         $this->save_candidate_address($this->parent_row_id);
        return $this->db->writer()->insert_id();
    }
    public function save_candidate_address($parent_row_id){
        $insert_data_address = array (
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'candidate_type' => '3', //Parent Addres
            'address_type' => $this->address_type,
            'candidate_id' => $parent_row_id
        );
        $this->db->writer()->insert($this->address_table,$insert_data_address);
    }
    public function update() 
    {
        $update_data = array (
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'contact_number1' => $this->contact_number1,
            'contact_number2' => $this->contact_number2,
            'primary_account' => $this->primary_account,
            'relationship' => $this->relationship,
            'email' => $this->email,
            'active' => $this->active
        );
        
        $where = array(
            'parent_id' => $this->parent_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        $this->update_candidate_address($this->parent_id);
        return $this->db->writer()->affected_rows();
    }
    public function update_candidate_address($parent_row_id){
        $update_data_address = array (
            'address_line1' => $this->address_line1,
            'address_line2' => $this->address_line2,
            'city' => $this->city,
            'state_id' => $this->state_id,
            'country_id' => $this->country_id,
            'candidate_type' => '2', //parent
            'address_type' => $this->address_type,
            'candidate_id' => $parent_row_id
        );
        $where = array(
            'candidate_id' => $this->parent_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->address_table,$update_data_address);
    }
    public function delete() 
    {
        $where = array(
            'parent_id' => $this->parent_id
        );
        
        $this->db->writer()
                ->where($where)
                ->delete($this->table);
        return $this->db->writer()->affected_rows();
    }
    
    public function get_parents($request_data) 
    {
        $parents = array();
        
        $columns = array( 
            // datatable column index  => database column name
            0 =>    'first_name', 
            1 =>    'last_name',
            2 =>    'email',
            3 =>    'active'

        );
        
        
        // get and set the total records count without filter
        $count_query = $this->db->reader()
                        ->select('COUNT(parent_id) AS tot_records')
                        ->from($this->table)
                        ->get();
        
        $result_set = $count_query->row();
        $parents['total_data'] = $result_set->tot_records;
        $parents['total_filtered'] = $parents['total_data'];
        
        // get and set the total filtered record counts after applied filter
        if( !empty($request_data['search']['value']) ) 
        {   
            $query = $this->db->reader()
                ->select('COUNT(parent_id) AS tot_records')
                ->from($this->table)
                ->where(" first_name LIKE '". $request_data['search']['value'] ."%'")    
                ->get();
            
            $result_set = $count_query->row();
            $parents['total_filtered'] = $result_set->tot_records;
            
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
        
        $parents['result'] = $data_query->result();
        return $parents;
    }    
    
    public function get_parent() 
    {
        $where = array(
            'parent_id' => $this->parent_id
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
            'candidate_id' => $this->parent_id
        );
        
        $query = $this->db->reader()
                ->select('*')
                ->from($this->address_table)
                ->where($where)
                ->get();
        
        return $query->result();
    }
    
}