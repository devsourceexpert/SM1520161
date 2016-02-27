<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Manage Academic Subjects
 */

class Academic_subject_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $academic_subject_id = 0;
    public $subject_name = null;
    public $academic_year_id = 0;
    public $active = 1; // default is active(1)
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->db = & get_instance()->db_mgr;
        $this->load->config('db_constants');
        $this->table = TBL_ACADEMIC_SUBJECTS;
    }

    public function save() 
    {
        $insert_data = array (
            'subject_name' => $this->subject_name,
            'academic_year_id' => $this->academic_year_id,
            'active' => $this->active
        );
        $this->db->writer()->insert($this->table,$insert_data);
        return $this->db->writer()->insert_id();
    }
    
    public function update() 
    {
        $update_data = array (
            'subject_name' => $this->subject_name,
            'academic_year_id' => $this->academic_year_id,
            'active' => $this->active
        );
        
        $where = array(
            'academic_subject_id' => $this->academic_subject_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        
        return $this->db->writer()->affected_rows();
    }

    public function delete() 
    {
        $where = array(
            'academic_subject_id' => $this->academic_subject_id
        );
        
        $this->db->writer()
                ->where($where)
                ->delete($this->table);
        return $this->db->writer()->affected_rows();
    }
    
    public function get_subjects($request_data) 
    {
        $subjects = array();
        
        $columns = array( 
            // datatable column index  => database column name
            0 =>    'subject_name', 
            1 =>    'active'
        );
        
        
        // get and set the total records count without filter
        $count_query = $this->db->reader()
                        ->select('COUNT(academic_subject_id) AS tot_records')
                        ->from($this->table)
                        ->where('academic_year_id', $this->academic_year_id)    
                        ->get();
        
        $result_set = $count_query->row();
        $subjects['total_data'] = $result_set->tot_records;
        $subjects['total_filtered'] = $subjects['total_data'];
        
        // get and set the total filtered record counts after applied filter
        if( !empty($request_data['search']['value']) ) 
        {   
            $query = $this->db->reader()
                ->select('COUNT(academic_subject_id) AS tot_records')
                ->from($this->table)
                ->where('academic_year_id', $this->academic_year_id)        
                ->where(" subject_name LIKE '". $request_data['search']['value'] ."%'")    
                ->get();
            
            $result_set = $count_query->row();
            $subjects['total_filtered'] = $result_set->tot_records;
            
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where('academic_year_id', $this->academic_year_id)                        
                ->where(" subject_name LIKE '". $request_data['search']['value'] ."%'") 
                ->order_by($columns[$request_data['order'][0]['column']], $request_data['order'][0]['dir'])
                ->limit($request_data['length'],$request_data['start'])
                ->get();
        } 
        else {
            $data_query = $this->db->reader()
                ->select('*')
                ->from($this->table)
                ->where('academic_year_id', $this->academic_year_id)         
                ->order_by($columns[$request_data['order'][0]['column']], $request_data['order'][0]['dir'])
                ->limit($request_data['length'],$request_data['start'])
                ->get();
        }
        
        $subjects['result'] = $data_query->result();
        return $subjects;
    }    
    
    public function get_active_subjects() {
        $subjects = array();
        $query = $this->db->reader()
                        ->select('*')
                        ->from($this->table)
                        ->where('active', 1)    
                        ->where('academic_year_id', $this->academic_year_id)    
                        ->get();
        $subjects = $query->result();
        return $subjects;
    }
    
    public function get_subject() 
    {
        $where = array(
            'academic_subject_id' => $this->academic_subject_id
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
                    ->select('academic_subject_id')
                    ->from($this->table)
                    ->where('subject_name',$this->subject_name)
                    ->where('academic_year_id', $this->academic_year_id)    
                    ->where('academic_subject_id !=', $this->academic_subject_id)
                    ->limit(1)->get()->num_rows();
        if($num_rows)
        {
            return false;
        }
        return true;
    }
    
}