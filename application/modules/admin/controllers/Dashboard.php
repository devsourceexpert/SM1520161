<?php

/* 
 * Created By : Saravanan
 * Created Date : 06th FEB, 2016
 * Description : Dashboard
 */
class Dashboard extends CI_Controller 
{

    public function __construct(){
        parent::__construct();
        $this->load->config('admin_constants');
        
    }
    public function index(){
        $this->load->template(strtolower(__CLASS__) . '/index'  );
    }

}
