<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Manage Academic Courses
 */

class Academic_course_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $academic_course_id = 0;
    public $academic_year_id = 0;
    public $course_name = null;
    public $from_month = 0;
    public $to_month = 0;
    public $group_name = null;
    
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->db = & get_instance()->db_mgr;
        $this->load->config('db_constants');
        $this->table = TBL_ACADEMIC_COURSES;
    }

    public function save() 
    {
        $insert_data = array (
            'academic_year_id' => $this->academic_year_id,
            'course_name' => $this->course_name,
            'from_month' => $this->from_month,
            'to_month' => $this->to_month,
            'group_name' => $this->group_name
            
        );
        $this->db->writer()->insert($this->table,$insert_data);
        return $this->db->writer()->insert_id();
    }
    
    public function update() 
    {
        $update_data = array (
            'academic_year_id' => $this->academic_year_id,
            'course_name' => $this->course_name,
            'from_month' => $this->from_month,
            'to_month' => $this->to_month,
            'group_name' => $this->group_name
        );
        
        $where = array(
            'academic_course_id' => $this->academic_course_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        
        return $this->db->writer()->affected_rows();
    }

    public function delete() 
    {
        $where = array(
            'academic_course_id' => $this->academic_course_id
        );
        
        $this->db->writer()
                ->where($where)
                ->delete($this->table);
        return $this->db->writer()->affected_rows();
    }
    
    public function get_academic_courses($request_data) 
    {
        $sections = array();
        
        $columns = array( 
            // datatable column index  => database column name
            0 =>    'academic_course_id', 
            1 =>    'course_name', 
            2 =>    'from_month', 
            3 =>    'to_month',
            4 =>    'group_name'
        );
        
        
        // get and set the total records count without filter
        $count_query = $this->db->reader()
                        ->select('COUNT(academic_course_id) AS tot_records')
                        ->from($this->table)
                        ->where('academic_year_id', $this->academic_year_id)
                        ->get();
        
        $result_set = $count_query->row();
        $sections['total_data'] = $result_set->tot_records;
        $sections['total_filtered'] = $sections['total_data'];
        
        // get and set the total filtered record counts after applied filter
        if( !empty($request_data['search']['value']) ) 
        {   
            $query = $this->db->reader()
                ->select('COUNT(academic_course_id) AS tot_records')
                ->from($this->table)
                ->where('academic_year_id', $this->academic_year_id)    
                ->where(" course_name LIKE '". $request_data['search']['value'] ."%'")    
                ->get();
            
            $result_set = $count_query->row();
            $sections['total_filtered'] = $result_set->tot_records;
            
            $data_query = $this->db->reader()
                ->select('C.*,GROUP_CONCAT(DISTINCT S.subject_name SEPARATOR "<BR>") subjects')
                ->from($this->table.' C')
                ->join(TBL_COURSES_SUBJECTS.' CS','CS.academic_course_id = C.academic_course_id AND CS.active = 1 ','left')        
                ->join(TBL_ACADEMIC_SUBJECTS.' S','S.academic_subject_id = CS.academic_subject_id AND S.active = 1 ','left')            
                ->where('C.academic_year_id', $this->academic_year_id)    
                ->where(" C.course_name LIKE '". $request_data['search']['value'] ."%'") 
                ->group_by('C.academic_course_id')    
                ->order_by($columns[$request_data['order'][0]['column']], $request_data['order'][0]['dir'])
                ->limit($request_data['length'],$request_data['start'])
                ->get();
        } 
        else {
            $data_query = $this->db->reader()
                ->select('C.*,GROUP_CONCAT(DISTINCT S.subject_name SEPARATOR "<BR>") subjects')
                ->from($this->table.' C')
                ->join(TBL_COURSES_SUBJECTS.' CS','CS.academic_course_id = C.academic_course_id AND CS.active = 1 ','left')        
                ->join(TBL_ACADEMIC_SUBJECTS.' S','S.academic_subject_id = CS.academic_subject_id AND S.active = 1 ','left')     
                ->where('C.academic_year_id', $this->academic_year_id)   
                ->group_by('C.academic_course_id')        
                ->order_by($columns[$request_data['order'][0]['column']], $request_data['order'][0]['dir'])
                ->limit($request_data['length'],$request_data['start'])
                ->get();
        }
        
        $sections['result'] = $data_query->result();
        return $sections;
    }    
    
    public function get_academic_course() 
    {
        $where = array(
            'academic_course_id' => $this->academic_course_id
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
                    ->select('academic_course_id')
                    ->from($this->table)
                    ->where('academic_year_id', $this->academic_year_id)    
                    ->where('course_name',$this->course_name)
                    ->where('academic_course_id !=', $this->academic_course_id)
                    ->limit(1)->get()->num_rows();
        if($num_rows)
        {
            return false;
        }
        return true;
    }
    
}