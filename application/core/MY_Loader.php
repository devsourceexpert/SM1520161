<?php
(defined('BASEPATH')) or exit('No direct script access allowed');

/* load the HMVC_Loader class */
require APPPATH . 'third_party/HMVC/Loader.php';

class MY_Loader extends HMVC_Loader {
    
    public function template($template_name, $vars = array(), $module_name = 'default',  $return = FALSE)  {
        
        if($module_name == 'default') {
            $module_name = '';
        }
        else {
            $module_name .= '/';
        }

        if($return) {
            
            $content  = $this->view($module_name . 'template/header', $vars, $return);
            $content .= $this->view( $template_name, $vars, $return);
            $content .= $this->view($module_name . 'template/footer', $vars, $return);
            return $content;
            
        }
        else {
            
            $this->view($module_name . 'template/header', $vars);
            $this->view( $template_name, $vars);
            $this->view($module_name .'template/footer', $vars);
            
        }
    }
}

