<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Model
 *
 * @author ian
 */
class MY_Model extends CI_Model {
    //put your code here
    
    var $is_admin;
    var $is_client;

    var $chipper_text;
    
    public function __construct() {
        parent::__construct();   
        
        $this->chipper_text = "amik-lp@gutsylab.com";
    }
    
    function get_level(){
        return get_session("level");
    }
    
    function is_superadmin(){
        // ** 
        // check if user logged in is_gutsy_admin
        $level = get_session("level");
        return trim($level) == "Super Administrator";
    }
    
    function is_admin(){
        // ** 
        // check if user logged in is_gutsy_admin
        $level = get_session("level");
        return trim($level) == "Administrator";
    }
    
    function is_user(){
        // ** 
        // check if user logged in is editor
        $level = get_session("level");
        return trim($level) == "User";
    }
    
    function encrypt_password($password){
        if(empty($password)) return "";
                
        $hash1 = md5($this->chipper_text);
        $hash2 = md5(sha1($hash1) . "&" . sha1($password));                
        $hash3 = sha1(md5("amik-lp") . "*" . md5($hash2));
        $hash4 = md5($hash3);

        return $hash4;
    }
    
    function post($key_post = ""){
        return $this->input->post($key_post);
    }
    
    function get($key_get = ""){
        return $this->input->get($key_post);
    }
  
    function get_filters_from_get($get = array()){
      $filters = array();
      

      $page = 1;
      $rows_per_page = ROWS_PER_PAGE;
      if(isset($get["page"])) $page = (int) $get["page"];
      if(isset($get["rows_per_page"])) $rows_per_page = (int) $rows_per_page;

      if($page < 1) $page = 1;
      if($rows_per_page < 1) $rows_per_page = ROWS_PER_PAGE;

      $filters["page"] = $page;
      $filters["rows_per_page"] = $rows_per_page;

      if(isset($get) && is_array($get) && count($get) > 0){
        foreach ($get as $key => $value) {
          $filters[$key] = $value;
        }
      }
      
      return $filters;
    }
}
