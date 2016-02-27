<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage Modules (Add, Edit, Activate/Deactivate)
 */
class Institute extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('dse_constants');
        $this->load->model('institute_model');
    }
    public function index(){
        $data['message'] = $this->session->flashdata('message');
        $this->load->template(strtolower(__CLASS__) . '/index',$data  );
    }
    public function create(){
        $data 						= array();
        $data['action'] 			= 'create';
        $data['title'] 				= 'Create ';
        $data['action_button_text'] = 'Save';
        $this->form_validation->set_rules('institute_name', 'Institute name', 'required|callback_unique_check');
		
        if ($this->form_validation->run() === FALSE){
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->institute_model->institute_id = $this->input->post('institute_id');
            $this->institute_model->institute_name = $this->input->post('institute_name');
            $this->institute_model->active = $this->input->post('active');
            $this->institute_model->save();
            
            $this->session->set_flashdata('message', 'Institute is created successfully');
            redirect(BASE_MODULE_URL . 'institute/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('institute_name', 'institute name', 'required|callback_unique_check');
        if ($this->form_validation->run() === FALSE)
        {
            $this->institute_model->institute_id 	= $this->uri->segment('4');
            $data['institute'] 				= $this->institute_model->get_institute();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->institute_model->institute_id 		= $this->input->post('institute_id');
            $this->institute_model->institute_name 	= $this->input->post('institute_name');
            $this->institute_model->active 		= $this->input->post('active');
            $this->institute_model->update();
            
            $this->session->set_flashdata('message', 'Institute is updated successfully');
            redirect(BASE_MODULE_URL . 'institute/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->institute_model->institute_id = $this->uri->segment('4');
        $this->institute_model->delete();
        $this->session->set_flashdata('message', 'Institute is deleted successfully');
        redirect(BASE_MODULE_URL . 'institute/index','refresh');
    }

    /*
     * Load All Modules
     */    
    public function load_institutes() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $result = $this->institute_model->get_institutes($request_data);
        
        
        foreach($result['result'] as $institute ) 
        {  
            $nested_data = array(); 

            $nested_data[] = $institute->institute_name;
            $nested_data[] = $institute->active == 0 ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>';
            
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'institute/edit/' . $institute->institute_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'institute/delete/' . $institute->institute_id . '" data-bb="confirm" class="'. $institute->institute_name .'">
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
    
    public function unique_check($institute_name) 
    {
        $this->institute_model->institute_id = $this->input->post('institute_id');
        $this->institute_model->institute_name = $institute_name; //$this->input->post('institute_name');
        
        if(!$this->institute_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'Institute name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }

}
