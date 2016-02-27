<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Manage Module
 */

class Institute_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $institute_id = 0;
    public $institute_name = null;
    public $active = 1; // default is active(1)
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->db = & get_instance()->db_mgr;
        $this->load->config('db_constants');
        $this->table = TBL_INSITUTES;
    }

    public function save() 
    {
        $insert_data = array (
            'institute_name' => $this->institute_name,
            'active' => $this->active
        );
        $this->db->writer()->insert($this->table,$insert_data);
        return $this->db->writer()->insert_id();
    }
    
    public function update() 
    {
        $update_data = array (
            'institute_name' => $this->institute_name,
            'active' => $this->active
        );
        
        $where = array(
            'institute_id' => $this->institute_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        
        return $this->db->writer()->affected_rows();
    }

    public function delete() 
    {
        $where = array(
            'institute_id' => $this->institute_id
        );
        
        $this->db->writer()
                ->where($where)
                ->delete($this->table);
        return $this->db->writer()->affected_rows();
    }
    
    public function get_institutes($request_data) 
    {
        $institutes = array();
        
        $columns = array( 
            // datatable column index  => database column name
            0 =>    'institute_name', 
            1 =>    'active'
        );
        
        
        // get and set the total records count without filter
        $count_query = $this->db->reader()
                        ->select('COUNT(institute_id) AS tot_records')
                        ->from($this->table)
                        ->get();
        
        $result_set = $count_query->row();
        $institutes['total_data'] = $result_set->tot_records;
        $institutes['total_filtered'] = $institutes['total_data'];
        
        // get and set the total filtered record counts after applied filter
        if( !empty($request_data['search']['value']) ) 
        {   
            $query = $this->db->reader()
                ->select('COUNT(institute_id) AS tot_records')
                ->from($this->table)
                ->where(" institute_name LIKE '". $request_data['search']['value'] ."%'")    
                ->get();
            
            $result_set = $count_query->row();
            $institutes['total_filtered'] = $result_set->tot_records;
            
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where(" institute_name LIKE '". $request_data['search']['value'] ."%'")        
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
        
        $institutes['result'] = $data_query->result();
        return $institutes;
    }    
    
    public function get_institute() 
    {
        $where = array(
            'institute_id' => $this->institute_id
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
                    ->select('institute_id')
                    ->from($this->table)
                    ->where('institute_name',$this->institute_name)
                    ->where('institute_id !=', $this->institute_id)
                    ->limit(1)->get()->num_rows();
        if($num_rows)
        {
            return false;
        }
        return true;
    }
    
}