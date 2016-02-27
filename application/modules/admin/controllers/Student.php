<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage Modules (Add, Edit, Activate/Deactivate)
 */
class Student extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('admin_constants');
        $this->load->model('student_model');
    }
    public function index(){
        $data['message'] = $this->session->flashdata('message');
        $this->load->template(strtolower(__CLASS__) . '/index',$data  );
    }
    public function create(){
        $data 					= array();
        $data['action'] 			= 'create';
        $data['title'] 				= 'Create ';
        $data['action_button_text'] = 'Save';
        $this->form_validation->set_rules('first_name', 'first name', 'required|callback_unique_check');
	$this->form_validation->set_rules('last_name', 'last name', 'required|callback_unique_check');
	//$this->form_validation->set_rules('admission_number', 'admission number', 'required|callback_unique_check');
        
        if ($this->form_validation->run() === FALSE){
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->student_model->student_id            = $this->input->post('student_id');
            $this->student_model->first_name            = $this->input->post('first_name');
            $this->student_model->last_name             = $this->input->post('last_name');
            $this->student_model->email                 = $this->input->post('email');
            $this->student_model->admission_number      = $this->input->post('admission_number');
            $this->student_model->admission_date        = $this->input->post('admission_date');
            $this->student_model->contact_number1       = $this->input->post('contact_number1');
            $this->student_model->contact_number2       = $this->input->post('contact_number2');
            $this->student_model->hostal_dayscholor     = $this->input->post('hostal_dayscholor');
            $this->student_model->physically_disabled   = $this->input->post('physically_disabled');
            $this->student_model->birth_date            = $this->input->post('birth_date');
            $this->student_model->disabled_description  = $this->input->post('disabled_description');
            $this->student_model->gender                = $this->input->post('gender');
            $this->student_model->active                = $this->input->post('active');
            //Address details of a student
            $this->student_model->address_line1     = $this->input->post('address_line1');
            $this->student_model->address_line2     = $this->input->post('address_line2');
            $this->student_model->city              = $this->input->post('city');
            $this->student_model->state_id          = $this->input->post('state_id');
            $this->student_model->country_id        = $this->input->post('country_id');
            $this->student_model->address_type      = $this->input->post('address_type');
            
            $this->student_model->active            = $this->input->post('active');
            
            
            $this->student_model->save();
            
            $this->session->set_flashdata('message', 'student is created successfully');
            redirect(BASE_MODULE_URL . 'student/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('first_name', 'student name', 'required|callback_unique_check');
        $this->form_validation->set_rules('last_name', 'last name', 'required|callback_unique_check');
        //$this->form_validation->set_rules('admission_number', 'admission number', 'required|callback_unique_check');        
        if ($this->form_validation->run() === FALSE)
        {
            $this->student_model->student_id 	= $this->uri->segment('4');
            $data['student'] 				= $this->student_model->get_student();
            $data['student_address'] 			= $this->student_model->get_address_book();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->student_model->student_id 		= $this->input->post('student_id');
            $this->student_model->first_name            = $this->input->post('first_name');
            $this->student_model->last_name             = $this->input->post('last_name');
            $this->student_model->email                 = $this->input->post('email');
            $this->student_model->admission_number 	= $this->input->post('admission_number');
            $this->student_model->admission_date        = $this->input->post('admission_date');
            $this->student_model->contact_number1       = $this->input->post('contact_number1');
            $this->student_model->contact_number2       = $this->input->post('contact_number2');
            $this->student_model->hostal_dayscholor     = $this->input->post('hostal_dayscholor');
            $this->student_model->physically_disabled   = $this->input->post('physically_disabled');
            $this->student_model->gender                = $this->input->post('gender');
            $this->student_model->birth_date            = $this->input->post('birth_date');
            $this->student_model->disabled_description = $this->input->post('disabled_description');            
            $this->student_model->active 		= $this->input->post('active');
            
            //Address details of a student
            $this->student_model->address_line1     = $this->input->post('address_line1');
            $this->student_model->address_line2     = $this->input->post('address_line2');
            $this->student_model->city              = $this->input->post('city');
            $this->student_model->state_id          = $this->input->post('state_id');
            $this->student_model->country_id        = $this->input->post('country_id');
            $this->student_model->address_type      = $this->input->post('address_type');
            $this->student_model->update();
            
            $this->session->set_flashdata('message', 'student is updated successfully');
            redirect(BASE_MODULE_URL . 'student/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->student_model->student_id = $this->uri->segment('4');
        $this->student_model->delete();
        $this->session->set_flashdata('message', 'student is deleted successfully');
        redirect(BASE_MODULE_URL . 'student/index','refresh');
    }

    /*
     * Load All Modules
     */    
    public function load_students() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $result = $this->student_model->get_students($request_data);
        
        
        foreach($result['result'] as $student ) 
        {  
            $nested_data = array(); 
            $nested_data[] = $student->admission_number;
            $nested_data[] = $student->admission_date;
            $nested_data[] = $student->first_name;
            $nested_data[] = $student->last_name;
            $nested_data[] = $student->email;
            $nested_data[] = $student->active == 0 ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>';
            
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'student/edit/' . $student->student_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'student/delete/' . $student->student_id . '" data-bb="confirm" class="'. $student->first_name .'">
                                <i class="glyphicon glyphicon-remove"></i>
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
    
    public function unique_check($first_name) 
    {
        $this->student_model->student_id = $this->input->post('student_id');
        $this->student_model->first_name = $first_name; //$this->input->post('first_name');
        if(!$this->student_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'student name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }

}
