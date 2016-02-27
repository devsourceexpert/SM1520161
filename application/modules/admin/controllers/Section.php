<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage Modules (Add, Edit, Activate/Deactivate)
 */
class Section extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('admin_constants');
        $this->load->model('section_model');
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
        $this->form_validation->set_rules('section_name', 'section name', 'required|callback_unique_check');
		
        if ($this->form_validation->run() === FALSE){
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->section_model->section_id = $this->input->post('section_id');
            $this->section_model->section_name = $this->input->post('section_name');
            $this->section_model->active = $this->input->post('active');
            $this->section_model->save();
            
            $this->session->set_flashdata('message', 'section is created successfully');
            redirect(BASE_MODULE_URL . 'section/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('section_name', 'section name', 'required|callback_unique_check');
        if ($this->form_validation->run() === FALSE)
        {
            $this->section_model->section_id 	= $this->uri->segment('4');
            $data['section'] 				= $this->section_model->get_section();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->section_model->section_id 		= $this->input->post('section_id');
            $this->section_model->section_name 	= $this->input->post('section_name');
            $this->section_model->active 		= $this->input->post('active');
            $this->section_model->update();
            
            $this->session->set_flashdata('message', 'section is updated successfully');
            redirect(BASE_MODULE_URL . 'section/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->section_model->section_id = $this->uri->segment('4');
        $this->section_model->delete();
        $this->session->set_flashdata('message', 'section is deleted successfully');
        redirect(BASE_MODULE_URL . 'section/index','refresh');
    }

    /*
     * Load All Modules
     */    
    public function load_sections() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $result = $this->section_model->get_sections($request_data);
        
        
        foreach($result['result'] as $section ) 
        {  
            $nested_data = array(); 

            $nested_data[] = $section->section_name;
            $nested_data[] = $section->active == 0 ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>';
            
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'section/edit/' . $section->section_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'section/delete/' . $section->section_id . '" data-bb="confirm" class="'. $section->section_name .'">
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
    
    public function unique_check($section_name) 
    {
        $this->section_model->section_id = $this->input->post('section_id');
        $this->section_model->section_name = $section_name; //$this->input->post('section_name');
        
        if(!$this->section_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'section name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }

}
