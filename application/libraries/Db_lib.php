<?php

/* 
 * Developer : Saravanan.S
 * Date : 26 JAN, 2016
 * Description : Multi-master replication layer
 */

class Db_lib  
{

    //later populate these arrays from database config directly
    private $master_db = 'master';
    private $arr_slave_db = array(0 => 'slave1');
    private $db_writer;
    private $db_reader;
    
    public function __construct()
    {   
        $CI =& get_instance();
        $CI->db_mgr=$this;
        $this->db_writer=$CI->load->database($this->master_db , TRUE);
        $this->db_reader=$this->loadreader();
    }    
    private function loadreader(){
        $CI =& get_instance();
        $num_db = ($CI->config->item('num_databases')) ? $CI->config->item('num_databases') : 1;
        if($num_db > 1) {
            $key = array_rand($this->arr_slave_db);
            return  $CI->load->database($this->arr_slave_db[$key], TRUE);
        } else {
            return $CI->load->database($this->master_db , TRUE);
        }
    
    }
    public function writer() {
        return $this->db_writer;
    }
    
    public function reader() {
        return $this->db_reader;
    }
    
}