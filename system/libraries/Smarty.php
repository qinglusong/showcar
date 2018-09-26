<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require BASEPATH."libraries/Smarty/Smarty.class.php";
class CI_Smarty extends Smarty
{

    function __construct(){
        parent::__construct();

        $this->left_delimiter = "<{";
        $this->right_delimiter = "}>";

		$this->template_dir = (!empty($config['smarty_template_dir']) ? $config['smarty_template_dir'] : APPPATH . 'views/');
        $this->compile_dir  = (!empty($config['smarty_compile_dir']) ? $config['smarty_compile_dir'] : APPPATH . 'cache/tpl_compile/');
        $this->caching = !empty($config['smarty_caching']) ? $config['smarty_caching'] : false;
        $this->cache_dir = !empty($config['smarty_cache_dir']) ? $config['smarty_cache_dir'] : APPPATH . 'cache/tpl_cache/';

        $this->assign( 'APPPATH', APPPATH );
        $this->assign( 'BASEPATH', BASEPATH );
 
        // Assign CodeIgniter object by reference to CI
        if ( method_exists( $this, 'assignByRef') ){
            $ci =& get_instance();
            $this->assignByRef("ci", $ci);
        }
        log_message('debug', "Smarty Class Initialized");
    }
    
    function view($template, $data = array(), $return = FALSE){
	    foreach ($data as $key => $val){
	      $this->assign($key, $val);
	    }

	    if ($return == FALSE){
	      $CI =& get_instance();
	      $CI->output->final_output = $this->fetch($template);
	      return;
	    }else{
	      return $this->fetch($template);
	    }
	  }
 
}

/* End of file Smarty.php */
/* Location: ./application/libraries/Smarty.php */
