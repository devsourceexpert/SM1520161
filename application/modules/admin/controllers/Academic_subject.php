<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage Modules (Add, Edit, Activate/Deactivate)
 */
class Academic_subject extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('admin_constants');
        $this->load->model('academic_subject_model');
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
        $this->form_validation->set_rules('subject_name', 'subject name', 'required|callback_unique_check');
		
        if ($this->form_validation->run() === FALSE){
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->academic_subject_model->academic_subject_id = $this->input->post('academic_subject_id');
            $this->academic_subject_model->academic_year_id      = $this->session->userdata('academic_year_id'); // institution id mapped internally
            $this->academic_subject_model->subject_name = $this->input->post('subject_name');
            $this->academic_subject_model->active = $this->input->post('active');
            $this->academic_subject_model->save();
            
            $this->session->set_flashdata('message', 'subject is created successfully');
            redirect(BASE_MODULE_URL . 'academic_subject/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('subject_name', 'subject name', 'required|callback_unique_check');
        if ($this->form_validation->run() === FALSE)
        {
            $this->academic_subject_model->academic_subject_id 	= $this->uri->segment('4');
            $data['subject'] 				= $this->academic_subject_model->get_subject();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->academic_subject_model->academic_subject_id 		= $this->input->post('academic_subject_id');
            $this->academic_subject_model->academic_year_id      = $this->session->userdata('academic_year_id'); // institution id mapped internally
            $this->academic_subject_model->subject_name 	= $this->input->post('subject_name');
            $this->academic_subject_model->active 		= $this->input->post('active');
            $this->academic_subject_model->update();
            
            $this->session->set_flashdata('message', 'subject is updated successfully');
            redirect(BASE_MODULE_URL . 'academic_subject/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->academic_subject_model->academic_subject_id = $this->uri->segment('4');
        $this->academic_subject_model->delete();
        $this->session->set_flashdata('message', 'subject is deleted successfully');
        redirect(BASE_MODULE_URL . 'academic_subject/index','refresh');
    }

    /*
     * Load All Modules
     */    
    public function load_subjects() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $this->academic_subject_model->academic_year_id      = $this->session->userdata('academic_year_id'); // institution id mapped internally
        $result = $this->academic_subject_model->get_subjects($request_data);
        
        
        foreach($result['result'] as $subject ) 
        {  
            $nested_data = array(); 

            $nested_data[] = $subject->subject_name;
            $nested_data[] = $subject->active == 0 ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>';
            
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'academic_subject/edit/' . $subject->academic_subject_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'academic_subject/delete/' . $subject->academic_subject_id . '" data-bb="confirm" class="'. $subject->subject_name .'">
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
    
    public function unique_check($subject_name) 
    {
        $this->academic_subject_model->academic_subject_id  = $this->input->post('academic_subject_id');
        $this->academic_subject_model->subject_name         = $subject_name; //$this->input->post('subject_name');
        $this->academic_subject_model->academic_year_id     = $this->session->userdata('academic_year_id'); // institution id mapped internally
        
        if(!$this->academic_subject_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'subject name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }

}
