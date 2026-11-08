<?php

class User_menu extends MY_Controller{

  function __construct(){
    parent::__construct();

    model("m_user_login", "model");
  }    

  function index(){
    //-- Index
    view("pages/user/user_menu/index");
  }

  function ajax_list(){
    //-- List
    $data = array();
    $data["list"] = $this->model->user_login_menu_get_list();

    view("pages/user/user_menu/ajax_list", $data);
  }

  function ajax_detail($hash_id = ""){
    //-- Detail
    $data = array();
    $data["detail"] = $this->model->user_login_menu_get($hash_id);
    $data["parent_list"] = $this->model->user_login_menu_get_parent_list();

    view("pages/user/user_menu/ajax_detail", $data);
  }

  function ajax_delete($hash_id = ""){
    //-- Delete
    $res = $this->model->user_login_menu_delete($hash_id);

    // ob_clean();
    echo json_encode($res);
  }

  function ajax_save(){
    //-- Save
    $res = $this->model->user_login_menu_save($_POST);

    // ob_clean();
    echo json_encode($res);
  }

  function ajax_set_order_up($hash_id = ""){
    //-- Order Up
    $res = $this->model->user_login_menu_update_sort_up($hash_id);

    ob_clean();
    echo json_encode($res);
  }

  function ajax_set_order_down($hash_id = ""){
    //-- Order Down
    $res = $this->model->user_login_menu_update_sort_down($hash_id);

    ob_clean();
    echo json_encode($res);
  }

}