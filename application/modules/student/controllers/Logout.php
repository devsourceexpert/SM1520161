<?php

/* 
 * Created By : Saravanan
 * Created Date : 06th FEB, 2016
 * Description : Admin Login
 */
class Logout extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('student_constants');
       
    }
    public function index() {

        $this->session->unset_userdata('student_logged_in');
        session_destroy();
        redirect(BASE_MODULE_URL.'login/', 'refresh');
    }
    
    
    

}
