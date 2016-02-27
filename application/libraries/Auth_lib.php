<?php

/* 
 * Developer : Saravanan.S
 * Date : 31 JAN, 2016
 * Description : Auth Lib
 */

class Auth_lib  
{
    private $CI = null;
    public function __construct()
    {   
        $CI =& get_instance();
        if( $CI->uri->segment(1) ) {
            $module = $CI->uri->segment(1);
            $this->$module();
        }
        
        
    }
    
    private function admin() {
        $CI =& get_instance();
        $user = $CI->session->userdata('logged_in');
        
        if(isset($user)) {
            $institution_data  = array(
                                'institution_id'        => '1', 
                                'academic_year_id'      => '1', 
                                'academic_from_year'    => '2016',
                                'academic_end_year'     => '2017',
                                'academic_year'         => '2016 - 2017',
                            );
            $CI->session->set_userdata( $institution_data );
            
            if( $CI->uri->segment(2) == 'login'  ) {
                redirect($CI->uri->segment(1).'/dashboard/', 'refresh');
            }
           
        } elseif( $CI->uri->segment(2) != 'login' ) {
            
            redirect($CI->uri->segment(1).'/login/', 'refresh');
            
        } 
    }
    private function student() {
        $CI =& get_instance();
        $user = $CI->session->userdata('student_logged_in');
        
        if(isset($user)) {
            $institution_data  = array(
                                'student_id'        => '1', 
                                'academic_year_id'      => '1', 
                                'academic_from_year'    => '2016',
                                'academic_end_year'     => '2017',
                                'academic_year'         => '2016 - 2017',
                            );
            $CI->session->set_userdata( $institution_data );
            
            if( $CI->uri->segment(2) == 'login'  ) {
                redirect($CI->uri->segment(1).'/dashboard/', 'refresh');
            }
           
        } elseif( $CI->uri->segment(2) != 'login' ) {
            
            redirect($CI->uri->segment(1).'/login/', 'refresh');
            
        } 
    }
    
    
    
}