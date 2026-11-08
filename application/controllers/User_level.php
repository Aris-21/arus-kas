<?php

class User_level extends MY_Controller{

  function __construct(){
    parent::__construct();

    model("m_user_login", "model");
  }    

  function index(){
    //-- Index
    view("pages/user/user_level/index");
  }

  function ajax_list(){
    //-- List
    $data = array();
    $data["list"] = $this->model->user_login_level_get_list();

    view("pages/user/user_level/ajax_list", $data);
  }

  function ajax_detail($hash_id = ""){
    //-- Detail
    $data = array();
    $data["detail"] = $this->model->user_login_level_get($hash_id);
    $data["user_menu_list"] = $this->model->user_login_menu_get_list();

    view("pages/user/user_level/ajax_detail", $data);
  }

  function ajax_delete($hash_id = ""){
    //-- Delete
    $res = $this->model->user_login_level_delete($hash_id);

    ob_clean();
    echo json_encode($res);
  }

  function ajax_save(){
    //-- Save
    $res = $this->model->user_login_level_save($_POST);

    ob_clean();
    echo json_encode($res);
  }

}