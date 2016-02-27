<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Manage Module
 */

class Academic_year_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $academic_year_id = 0;
    public $from_year = null;
    public $active = 1; // default is active(1)
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->db = & get_instance()->db_mgr;
        $this->load->config('db_constants');
        $this->table = TBL_ACADEMIC_YEARS;
    }

    public function save() 
    {
        $insert_data = array (
            'from_year' => $this->from_year,
			'to_year' => $this->to_year,
            'active' => $this->active
        );
        $this->db->writer()->insert($this->table,$insert_data);
        return $this->db->writer()->insert_id();
    }
    
    public function update() 
    {
        $update_data = array (
            'from_year' => $this->from_year,
			'to_year' => $this->to_year,
            'active' => $this->active
        );
        
        $where = array(
            'academic_year_id' => $this->academic_year_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        
        return $this->db->writer()->affected_rows();
    }

    public function delete() 
    {
        $where = array(
            'academic_year_id' => $this->academic_year_id
        );
        
        $this->db->writer()
                ->where($where)
                ->delete($this->table);
        return $this->db->writer()->affected_rows();
    }
    
    public function get_academic_years($request_data) 
    {
        $academic_years = array();
        
        $columns = array( 
            // datatable column index  => database column name
            0 =>    'from_year', 
            1 =>    'active'
        );
        
        
        // get and set the total records count without filter
        $count_query = $this->db->reader()
                        ->select('COUNT(academic_year_id) AS tot_records')
                        ->from($this->table)
                        ->get();
        
        $result_set = $count_query->row();
        $academic_years['total_data'] = $result_set->tot_records;
        $academic_years['total_filtered'] = $academic_years['total_data'];
        
        // get and set the total filtered record counts after applied filter
        if( !empty($request_data['search']['value']) ) 
        {   
            $query = $this->db->reader()
                ->select('COUNT(academic_year_id) AS tot_records')
                ->from($this->table)
                ->where(" from_year LIKE '". $request_data['search']['value'] ."%' ")    
                ->get();
            
            $result_set = $count_query->row();
            $academic_years['total_filtered'] = $result_set->tot_records;
            
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where(" from_year LIKE '". $request_data['search']['value'] ."%'")        
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
        
        $academic_years['result'] = $data_query->result();
        return $academic_years;
    }    
    
    public function get_academic_year() 
    {
        $where = array(
            'academic_year_id' => $this->academic_year_id
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
                    ->select('academic_year_id')
                    ->from($this->table)
                    ->where('from_year',$this->from_year)
                    ->where('academic_year_id !=', $this->academic_year_id)
                    ->limit(1)->get()->num_rows();
        if($num_rows)
        {
            return false;
        }
        return true;
    }
    
}