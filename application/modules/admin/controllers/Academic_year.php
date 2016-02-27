<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage Modules (Add, Edit, Activate/Deactivate)
 */
class Academic_year extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('admin_constants');
        $this->load->model('academic_year_model');
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
        $this->form_validation->set_rules('from_year', 'from year', 'required|callback_unique_check');
		$this->form_validation->set_rules('to_year', 'to year', 'required|callback_unique_check');

		
        if ($this->form_validation->run() === FALSE){
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->academic_year_model->academic_year_id = $this->input->post('academic_year_id');
            $this->academic_year_model->from_year = $this->input->post('from_year');
			$this->academic_year_model->to_year = $this->input->post('to_year');
            $this->academic_year_model->active = $this->input->post('active');
            $this->academic_year_model->save();
            
            $this->session->set_flashdata('message', 'academic_year is created successfully');
            redirect(BASE_MODULE_URL . 'academic_year/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('from_year', 'from year', 'required|callback_unique_check');
		        $this->form_validation->set_rules('to_year', 'to year', 'required|callback_unique_check');

        if ($this->form_validation->run() === FALSE)
        {
            $this->academic_year_model->academic_year_id 	= $this->uri->segment('4');
            $data['academic_year'] 				= $this->academic_year_model->get_academic_year();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->academic_year_model->academic_year_id 		= $this->input->post('academic_year_id');
            $this->academic_year_model->from_year 	= $this->input->post('from_year');
			$this->academic_year_model->to_year 	= $this->input->post('to_year');
            $this->academic_year_model->active 		= $this->input->post('active');
            $this->academic_year_model->update();
            
            $this->session->set_flashdata('message', 'academic_year is updated successfully');
            redirect(BASE_MODULE_URL . 'academic_year/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->academic_year_model->academic_year_id = $this->uri->segment('4');
        $this->academic_year_model->delete();
        $this->session->set_flashdata('message', 'academic_year is deleted successfully');
        redirect(BASE_MODULE_URL . 'academic_year/index','refresh');
    }

    /*
     * Load All Modules
     */    
    public function load_academic_years() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $result = $this->academic_year_model->get_academic_years($request_data);
        
        
        foreach($result['result'] as $academic_year ) 
        {  
            $nested_data = array(); 

            $nested_data[] = $academic_year->from_year;
			$nested_data[] = $academic_year->to_year;
            $nested_data[] = $academic_year->active == 0 ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>';
            
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'academic_year/edit/' . $academic_year->academic_year_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'academic_year/delete/' . $academic_year->academic_year_id . '" data-bb="confirm" class="'. $academic_year->from_year .'">
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
    
    public function unique_check($from_year) 
    {
        $this->academic_year_model->academic_year_id = $this->input->post('academic_year_id');
        $this->academic_year_model->from_year = $from_year; //$this->input->post('from_year');
        
        if(!$this->academic_year_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'academic_year name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }

}
