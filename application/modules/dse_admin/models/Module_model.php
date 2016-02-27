<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Manage Module
 */

class Module_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $module_id = 0;
    public $module_name = null;
    public $active = 1; // default is active(1)
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->db = & get_instance()->db_mgr;
        $this->load->config('db_constants');
        $this->table = TBL_MODULES;
    }

    public function save() 
    {
        $insert_data = array (
            'module_name' => $this->module_name,
            'active' => $this->active
        );
        $this->db->writer()->insert($this->table,$insert_data);
        return $this->db->writer()->insert_id();
    }
    
    public function update() 
    {
        $update_data = array (
            'module_name' => $this->module_name,
            'active' => $this->active
        );
        
        $where = array(
            'module_id' => $this->module_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        
        return $this->db->writer()->affected_rows();
    }

    public function delete() 
    {
        $where = array(
            'module_id' => $this->module_id
        );
        
        $this->db->writer()
                ->where($where)
                ->delete($this->table);
        return $this->db->writer()->affected_rows();
    }
    
    public function get_modules($request_data) 
    {
        $modules = array();
        
        $columns = array( 
            // datatable column index  => database column name
            0 =>    'module_name', 
            1 =>    'active'
        );
        
        
        // get and set the total records count without filter
        $count_query = $this->db->reader()
                        ->select('COUNT(module_id) AS tot_records')
                        ->from($this->table)
                        ->get();
        
        $result_set = $count_query->row();
        $modules['total_data'] = $result_set->tot_records;
        $modules['total_filtered'] = $modules['total_data'];
        
        // get and set the total filtered record counts after applied filter
        if( !empty($request_data['search']['value']) ) 
        {   
            $query = $this->db->reader()
                ->select('COUNT(module_id) AS tot_records')
                ->from($this->table)
                ->where(" module_name LIKE '". $request_data['search']['value'] ."%'")    
                ->get();
            
            $result_set = $count_query->row();
            $modules['total_filtered'] = $result_set->tot_records;
            
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where(" module_name LIKE '". $request_data['search']['value'] ."%'")        
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
        
        $modules['result'] = $data_query->result();
        return $modules;
    }    
    
    public function get_module() 
    {
        $where = array(
            'module_id' => $this->module_id
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
                    ->select('module_id')
                    ->from($this->table)
                    ->where('module_name',$this->module_name)
                    ->where('module_id !=', $this->module_id)
                    ->limit(1)->get()->num_rows();
        if($num_rows)
        {
            return false;
        }
        return true;
    }
    
}