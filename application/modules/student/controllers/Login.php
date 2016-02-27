<?php

/* 
 * Created By : Saravanan
 * Created Date : 06th FEB, 2016
 * Description : Admin Login
 */
class Login extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('student_constants');
        $this->load->model('user_model');
    }
    public function index() {

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_login');
 
        if($this->form_validation->run() == FALSE)
        {
          //Field validation failed.  User redirected to login page
          $this->load->template(strtolower(__CLASS__) . '/index'  );
        }
        else
        {
          //Go to private area
          redirect( BASE_MODULE_URL.'dashboard/index', 'refresh');
        }
    }
    
    function check_login($password) {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');
        $this->user_model->username = $username;
        $this->user_model->password = $password; 
        password_hash($password, PASSWORD_DEFAULT);
        $result = $this->user_model->login();
 
        if($result) {
            $sess_array = array();
            foreach($result as $row) {
                if (!password_verify($password,$row->password)) {
                    $this->form_validation->set_message('check_login', 'Invalid username or password');
                    return false;
                }
                $sess_array = array(
                    'user_id'   => $row->user_id,
                    'username'  => $row->username,
                    'name'      => $row->first_name.' '.$row->last_name    
                );
                $this->session->set_userdata('student_logged_in', $sess_array);
            }
            return true;
        }
        else
        {
            $this->form_validation->set_message('check_login', 'Invalid username or password');
            return false;
        }
    }
    

}
