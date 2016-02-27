<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage Modules (Add, Edit, Activate/Deactivate)
 */
class Module extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('dse_constants');
        $this->load->model('module_model');
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
        $this->form_validation->set_rules('module_name', 'Module name', 'required|callback_unique_check');
		
        if ($this->form_validation->run() === FALSE){
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->module_model->module_id = $this->input->post('module_id');
            $this->module_model->module_name = $this->input->post('module_name');
            $this->module_model->active = $this->input->post('active');
            $this->module_model->save();
            
            $this->session->set_flashdata('message', 'Module is created successfully');
            redirect(BASE_MODULE_URL . 'module/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('module_name', 'module name', 'required|callback_unique_check');
        if ($this->form_validation->run() === FALSE)
        {
            $this->module_model->module_id 	= $this->uri->segment('4');
            $data['module'] 				= $this->module_model->get_module();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->module_model->module_id 		= $this->input->post('module_id');
            $this->module_model->module_name 	= $this->input->post('module_name');
            $this->module_model->active 		= $this->input->post('active');
            $this->module_model->update();
            
            $this->session->set_flashdata('message', 'Module is updated successfully');
            redirect(BASE_MODULE_URL . 'module/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->module_model->module_id = $this->uri->segment('4');
        $this->module_model->delete();
        $this->session->set_flashdata('message', 'Module is deleted successfully');
        redirect(BASE_MODULE_URL . 'module/index','refresh');
    }

    /*
     * Load All Modules
     */    
    public function load_modules() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $result = $this->module_model->get_modules($request_data);
        
        
        foreach($result['result'] as $module ) 
        {  
            $nested_data = array(); 

            $nested_data[] = $module->module_name;
            $nested_data[] = $module->active == 0 ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>';
            
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'module/edit/' . $module->module_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'module/delete/' . $module->module_id . '" data-bb="confirm" class="'. $module->module_name .'">
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
    
    public function unique_check($module_name) 
    {
        $this->module_model->module_id = $this->input->post('module_id');
        $this->module_model->module_name = $module_name; //$this->input->post('module_name');
        
        if(!$this->module_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'Module name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }

}
