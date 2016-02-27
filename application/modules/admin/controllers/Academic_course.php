<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage Modules (Add, Edit, Activate/Deactivate)
 */
class Academic_course extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('admin_constants');
        $this->load->model('academic_course_model');
        $this->load->model('academic_subject_model');
        $this->load->model('course_subject_model');
        
    }
    public function index(){
        $data['message'] = $this->session->flashdata('message');
        $this->academic_subject_model->academic_year_id  = $this->session->userdata('academic_year_id'); // institution id mapped internally
        $data['subjects'] = $this->academic_subject_model->get_active_subjects();
        $this->load->template(strtolower(__CLASS__) . '/index',$data  );
    }
    public function create(){
        $data                       = array();
        $data['action']             = 'create';
        $data['title']              = 'Create ';
        $data['action_button_text'] = 'Save';
       
        $this->form_validation->set_rules('course_name', 'course name', 'required|callback_unique_check');
        $this->form_validation->set_rules('from_month', 'from month', 'required');
        $this->form_validation->set_rules('to_month', 'to month', 'required');
		
        if ($this->form_validation->run() === FALSE){
           
        
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );

        }
        else {
            $this->academic_course_model->academic_course_id    = $this->input->post('academic_course_id');
            $this->academic_course_model->academic_year_id      = $this->session->userdata('academic_year_id'); // institution id mapped internally
            $this->academic_course_model->course_name           = $this->input->post('course_name');
            $this->academic_course_model->from_month            = $this->input->post('from_month');
            $this->academic_course_model->to_month              = $this->input->post('to_month');
            $this->academic_course_model->group_name            = $this->input->post('group_name');
            $this->academic_course_model->save();
            
            $this->session->set_flashdata('message', 'Course is created successfully');
            redirect(BASE_MODULE_URL . 'academic_course/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('course_name', 'course name', 'required|callback_unique_check');
        $this->form_validation->set_rules('from_month', 'from month', 'required');
        $this->form_validation->set_rules('to_month', 'to month', 'required');
        
        if ($this->form_validation->run() === FALSE)
        {
            $this->academic_course_model->academic_course_id 	= $this->uri->segment('4');
            $data['academic_course']                            = $this->academic_course_model->get_academic_course();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->academic_course_model->academic_course_id    = $this->input->post('academic_course_id');
            $this->academic_course_model->academic_year_id      = $this->session->userdata('academic_year_id'); // institution id mapped internally
            $this->academic_course_model->course_name           = $this->input->post('course_name');
            $this->academic_course_model->from_month            = $this->input->post('from_month');
            $this->academic_course_model->to_month              = $this->input->post('to_month');
            $this->academic_course_model->group_name            = $this->input->post('group_name');
            $this->academic_course_model->update();
            $this->session->set_flashdata('message', 'Course is updated successfully');
            redirect(BASE_MODULE_URL . 'academic_course/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->academic_course_model->academic_course_id = $this->uri->segment('4');
        $this->academic_course_model->delete();
        $this->session->set_flashdata('message', 'Course is deleted successfully');
        redirect(BASE_MODULE_URL . 'academic_course/index','refresh');
    }

    
    /*
     * Load All Modules
     */    
    public function load_academic_courses() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $this->academic_course_model->academic_year_id = $this->session->userdata('academic_year_id');
        $result = $this->academic_course_model->get_academic_courses($request_data);
        
        
        foreach($result['result'] as $academic_course ) 
        {  
            $nested_data = array(); 

            $nested_data[] = $academic_course->course_name;
            $nested_data[] = date("F", mktime(0, 0, 0, $academic_course->from_month, 10));
            $nested_data[] = date("F", mktime(0, 0, 0, $academic_course->to_month, 10));
            $nested_data[] = $academic_course->subjects;
            $nested_data[] = $academic_course->group_name;
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'academic_course/edit/' . $academic_course->academic_course_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'academic_course/delete/' . $academic_course->academic_course_id . '" data-bb="confirm" class="'. $academic_course->course_name .'">
                                <i class="glyphicon glyphicon-remove"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="#" id="academic_course_id_'. $academic_course->academic_course_id .'" class="'. $academic_course->course_name .'">
                                Assign Subjects
                            </a>
                        </span>';
            
            $nested_data[] 	= $action;
            $data[] 		= $nested_data;
        }

        /*
         * Param : draw             //  for every request/draw by clientside , 
         *                              they send a number as a parameter, when they recieve a response/data they first check the draw number, 
         *                              so we are sending same number in draw.  
         * Param : recordsTotal     //  total number of records
         * Param : recordsFiltered  //  total number of records after searching, if there is no searching then totalFiltered = totalData
         * Param :                  //  total data array
         */
        $json_data = array(
                        "draw"            => intval( $request_data['draw'] ),   
                        "recordsTotal"    => intval( $result['total_data'] ),  
                        "recordsFiltered" => intval( $result['total_filtered'] ), 
                        "data"            => $data    
                    );

        echo json_encode($json_data);  
        
    }
    
    public function unique_check($course_name) 
    {
        $this->academic_course_model->academic_course_id = $this->input->post('academic_course_id');
        $this->academic_course_model->academic_year_id = $this->session->userdata('academic_year_id'); // institution id mapped internally
        $this->academic_course_model->course_name = $course_name; //$this->input->post('section_name');
        
        if(!$this->academic_course_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'course name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }
    
    public function load_course_subjects() {

        $this->course_subject_model->academic_course_id = $this->input->post('academic_course_id');
        $course_subjects = $this->course_subject_model->get_mapped_subjects();
       
        echo json_encode($course_subjects);
    }
    
    public function save_course_subjects() {
        $this->course_subject_model->academic_course_id = $this->input->post('academic_course_id');
        $subject_ids = explode('_', $this->input->post('subject_ids'));
        unset($subject_ids[0]);
        
        $this->course_subject_model->deactivate_all();
        foreach($subject_ids as $subject_id) {
            
            $this->course_subject_model->academic_subject_id = $subject_id;
            if(!$this->course_subject_model->unique_check()) {
                $this->course_subject_model->activate();
            } else {
                $this->course_subject_model->save();
            }
        }
        
    }

}
