<?php

/* 
 * Created By : Saravanan
 * Created Date : 24th JAN, 2016
 * Description : Manage boards (Add, Edit, Activate/Deactivate)
 */
class Education_board extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('dse_constants');
        $this->load->model('education_board_model');
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
        $this->form_validation->set_rules('board_name', 'board name', 'required|callback_unique_check');
		
        if ($this->form_validation->run() === FALSE){
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->education_board_model->board_id = $this->input->post('board_id');
            $this->education_board_model->board_name = $this->input->post('board_name');
            $this->education_board_model->active = $this->input->post('active');
            $this->education_board_model->save();
            
            $this->session->set_flashdata('message', 'board is created successfully');
            redirect(BASE_MODULE_URL . 'education_board/index','refresh');
        }
    }
    public function edit(){
        $data 						= array();
        $data['action'] 			= 'edit';
        $data['title'] 				= 'Edit ';
        $data['action_button_text'] = 'Update';

        $this->form_validation->set_rules('board_name', 'board name', 'required|callback_unique_check');
        if ($this->form_validation->run() === FALSE)
        {
            $this->education_board_model->board_id 	= $this->uri->segment('4');
            $data['board'] 				= $this->education_board_model->get_board();
            $this->load->template(strtolower(__CLASS__) . '/create', $data  );
        }
        else
        {
            $this->education_board_model->board_id 		= $this->input->post('board_id');
            $this->education_board_model->board_name 	= $this->input->post('board_name');
            $this->education_board_model->active 		= $this->input->post('active');
            $this->education_board_model->update();
            
            $this->session->set_flashdata('message', 'board is updated successfully');
            redirect(BASE_MODULE_URL . 'education_board/index','refresh');
            
        }
    }    
    
    public function delete() 
    {
        $this->education_board_model->board_id = $this->uri->segment('4');
        $this->education_board_model->delete();
        $this->session->set_flashdata('message', 'board is deleted successfully');
        redirect(BASE_MODULE_URL . 'education_board/index','refresh');
    }

    /*
     * Load All boards
     */    
    public function load_boards() 
    {
        $data = array();
        $request_data = $_REQUEST;
        $result = $this->education_board_model->get_boards($request_data);
        
        
        foreach($result['result'] as $board ) 
        {  
            $nested_data = array(); 

            $nested_data[] = $board->board_name;
            $nested_data[] = $board->active == 0 ? '<i class="glyphicon glyphicon-remove"></i>' : '<i class="glyphicon glyphicon-ok"></i>';
            
            $action =  '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'education_board/edit/' . $board->board_id . '" >
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </span>';  
            
            $action .= '<span class="action_span">
                            <a href="' . BASE_MODULE_URL . 'education_board/delete/' . $board->board_id . '" data-bb="confirm" class="'. $board->board_name .'">
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
    
    public function unique_check($board_name) 
    {
        $this->education_board_model->board_id = $this->input->post('board_id');
        $this->education_board_model->board_name = $board_name; //$this->input->post('board_name');
        
        if(!$this->education_board_model->unique_check())
        {
            $this->form_validation->set_message('unique_check', 'board name is already exists');
            return false;
        } 
        else 
        {
            return true;
        }

    }

}
