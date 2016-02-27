<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage Modules (Add, Edit, Activate/Deactivate)
 */
class Parents extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('admin_constants');
        $this->load->model('parents_model');
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
        $this->form_validation->set_rules('first_name', 'first name', 'required');
	$this->form_validation->set_rules('last_name', 'last name', 'required');
        if ($this->form_validation->run() === FALSE){
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->parents_model->parent_id          = $this->input->post('parent_id');
            $this->parents_model->first_name         = $this->input->post('first_name');
            $this->parents_model->last_name          = $this->input->post('last_name');
            $this->parents_model->email              = $this->input->post('email');
            $this->parents_model->contact_number1    = $this->input->post('contact_number1');
            $this->parents_model->contact_number2    = $this->input->post('contact_number2');
            $this->parents_model->primary_account    = $this->input->post('primary_account');
            $this->parents_model->relationship       = $this->input->post('relationship');
            $this->parents_model->active             = $this->input->post('active');
            
            //Address details of a student
            $this->parents_model->address_line1     = $this->input->post('address_line1');
            $this->parents_model->address_line2     = $this->input->post('address_line2');
            $this->parents_model->city              = $this->input->post('city');
            $this->parents_model->state_id          = $this->input->post('state_id');
            $this->parents_model->country_id        = $this->input->post('country_id');
            $this->parents_model->address_type      = $this->input->post('address_type');
            
            $this->parents_model->save();
            $this->session->set_flashdata('message', 'parent is created successfully');
            redirect(BASE_MODULE_URL . 'parents/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('first_name', 'parent name', 'required');
        $this->form_validation->set_rules('last_name', 'last name', 'required');
        //$this->form_validation->set_rules('admission_number', 'admission number', 'required|callback_unique_check');        
        if ($this->form_validation->run() === FALSE)
        {
            $this->parents_model->parent_id 	= $this->uri->segment('4');
            $data['parent'] 				= $this->parents_model->get_parent();
            $data['parent_address'] 			= $this->parents_model->get_address_book();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->parents_model->parent_id          = $this->input->post('parent_id');
            $this->parents_model->first_name         = $this->input->post('first_name');
            $this->parents_model->last_name          = $this->input->post('last_name');
            $this->parents_model->email              = $this->input->post('email');
            $this->parents_model->contact_number1       = $this->input->post('contact_number1');
            $this->parents_model->contact_number2       = $this->input->post('contact_number2');
            $this->parents_model->primary_account     = $this->input->post('primary_account');
            $this->parents_model->relationship   = $this->input->post('relationship');            
            $this->parents_model->active 		= $this->input->post('active');
            
            //Address details of a student
            $this->parents_model->address_line1     = $this->input->post('address_line1');
            $this->parents_model->address_line2     = $this->input->post('address_line2');
            $this->parents_model->city              = $this->input->post('city');
            $this->parents_model->state_id          = $this->input->post('state_id');
            $this->parents_model->country_id        = $this->input->post('country_id');
            $this->parents_model->address_type      = $this->input->post('address_type');
            
            $this->parents_model->update();
            
            $this->session->set_flashdata('message', 'parent is updated successfully');
            redirect(BASE_MODULE_URL . 'parents/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->parents_model->parent_id = $this->uri->segment('4');
        $this->parents_model->delete();
        $this->session->set_flashdata('message', 'parent is deleted successfully');
        redirect(BASE_MODULE_URL . 'parents/index','refresh');
    }

    /*
     * Load All Modules
     */    
    public function load_parents() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $result = $this->parents_model->get_parents($request_data);
        
        
        foreach($result['result'] as $parent ) 
        {  
            $nested_data = array(); 
            $nested_data[] = $parent->first_name;
            $nested_data[] = $parent->last_name;
            $nested_data[] = $parent->email;
           
            $nested_data[] = $parent->active == 0 ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>';
            
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'parents/edit/' . $parent->parent_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'parents/delete/' . $parent->parent_id . '" data-bb="confirm" class="'. $parent->first_name .'">
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
        $this->parents_model->parent_id = $this->input->post('parent_id');
        $this->parents_model->first_name = $first_name; //$this->input->post('first_name');
        if(!$this->parents_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'parent name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }

}
