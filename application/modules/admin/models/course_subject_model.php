<?php
/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Manage Academic Courses
 */

class Course_subject_model extends CI_Model 
{
    private $db;
    private $table = null;
    
    public $course_subject_id   = 0;
    public $academic_course_id  = 0;
    public $academic_subject_id = 0;
    public $active = 1;
    
    	
    
    
    
    public function __construct() 
    {
        parent::__construct();
        $this->db = & get_instance()->db_mgr;
        $this->load->config('db_constants');
        $this->table = TBL_COURSES_SUBJECTS;
    }

    public function save() 
    {
        $insert_data = array (
            'academic_course_id' => $this->academic_course_id,
            'academic_subject_id' => $this->academic_subject_id,
            'active' => $this->active    
        );
        $this->db->writer()->insert($this->table,$insert_data);
        return $this->db->writer()->insert_id();
    }
    
    public function deactivate_all() 
    {
        $update_data = array (
            'active' => 0
        );
        
        $where = array(
            'academic_course_id' => $this->academic_course_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        
        return $this->db->writer()->affected_rows();
    }
    public function activate() 
    {
        $update_data = array (
            'active' => 1
        );
        
        $where = array(
            'academic_course_id' => $this->academic_course_id,
            'academic_subject_id' => $this->academic_subject_id
        );
        
        $this->db->writer()
                ->where($where)
                ->update($this->table,$update_data);
        
        return $this->db->writer()->affected_rows();
    }
    
    public function get_mapped_subjects() 
    {
        $where = array(
            'academic_course_id' => $this->academic_course_id,
            'active' => 1
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
                    ->select('course_subject_id')
                    ->from($this->table)
                    ->where('academic_subject_id',$this->academic_subject_id)
                    ->where('academic_course_id', $this->academic_course_id)
                    ->limit(1)->get()->num_rows();
        if($num_rows)
        {
            return false;
        }
        return true;
    }
    
}