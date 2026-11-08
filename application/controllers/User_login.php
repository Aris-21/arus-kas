<?php

class User_login extends MY_Controller{

  function __construct(){
    parent::__construct();

    model("m_user_login", "model");
  }    

  function index(){
    //-- Index
    view("pages/user/user_login/index");
  }

  function ajax_list(){
    //-- List
    $data = array();
    $data["list"] = $this->model->user_login_get_list();

    view("pages/user/user_login/ajax_list", $data);
  }

  function ajax_detail($hash_id = ""){
    //-- Detail
    $data = array();
    $data["detail"] = $this->model->user_login_get($hash_id);
    $data["user_login_level_list"] = $this->model->user_login_level_get_list();

    view("pages/user/user_login/ajax_detail", $data);
  }

  function ajax_delete($hash_id = ""){
    //-- Delete
    $res = $this->model->user_login_delete($hash_id);

    ob_clean();
    echo json_encode($res);
  }

  function ajax_save(){
    //-- Save
    $res = $this->model->user_login_save($_POST);

    // ob_clean();
    echo json_encode($res);
  }

  function ajax_reset_password(){
    //-- Reset Password
    $res = $this->model->user_login_reset_password($_POST);

    // ob_clean();
    echo json_encode($res);
  }

  function ajax_get_employee_name_for_employee_number_formatted(){
    //-- Get Employee Name    
    $res = $this->model->get_employee_name_for_employee_number_formatted($_GET["employee_number_formatted"]);

    // ob_clean();
    echo json_encode($res);
  }

  function ajax_change_password(){
    //-- User Change Password
    $res = $this->model->user_login_change_password($_POST);

    //ob_clean();
    echo json_encode($res);
  }
}