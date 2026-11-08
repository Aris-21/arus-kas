<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_engine
 *
 * @author ian
 */
class User_engine extends Db_engine {
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    // ====================================================
    // ** OBJECT USER LOGIN
    // ====================================================
    function user_login_get_list($filters = array()){
        $this->db->select("
            user_login.*, 
            user_login_level.name user_login_level_name
        ");
        $this->db->from("user_login");
        $this->db->join("user_login_level", "user_login_level.id = user_login.user_login_level_id", "left");
        
        foreach ($filters as $key => $value) {
            switch ($key) {
                case "id":
                    $this->db->where("user_login.id", (int)$value);
                    break;
                case "username":
                    $this->db->where("user_login.username", trim($value));
                    break;
                case "user_login_level_id":
                    $this->db->where("user_login.user_login_level_id", (int)$value);
                    break;
                default:
                    break;
            }
        }
        
        $res = $this->db->get()->result_array();
        return $res;
    }
    
    function user_login_get($id = 0){
        if($id == 0) return array();
        
        $filters = array(
            "id" => $id
        );
        $res = $this->user_login_get_list($filters);
        
        if(count($res) == 0) return array();
        return $res[0];
    }
    
    function user_login_save($data = array()){
        $id = (int) $data["id"];
        $creator_user_id = (int) $data["creator_user_id"];
        $creator_user_name = trim($data["creator_user_name"]);
        $name = trim($data["name"]);
        $username = trim($data["username"]);
        $password = trim($data["password"]);
        $user_login_level_id = trim($data["user_login_level_id"]);

        $this->db->set(array(
            "id" => $id, 
            "created" => date("Y-m-d H:i:s"),
            "creator_user_id" => $creator_user_id, 
            "creator_user_name" => $creator_user_name, 
            "name" => $name, 
            "username" => $username, 
            "password" => $password, 
            "user_login_level_id" => $user_login_level_id, 
        ));
        $this->db->replace("user_login");

        if($id == 0) return $this->db->insert_id();
        return $id;
    }
    
    function user_login_delete($id = 0){
        if($id == 0) return 0;
        
        $this->db->where("id", $id);
        $this->db->delete("user_login");
        
        return $id;
    }
    
    function user_login_update_password($id = 0, $password = ""){
        if((int)$id == 0) return 0;
        if(trim($password) == "") return 0;
        
        $this->db->set("password", $password);
        $this->db->where("id", $id);
        $this->db->update("user_login");
        
        return $id;
    }    
    // ====================================================
    // ** END -- OBJECT USER LOGIN
    // ====================================================


    // ====================================================
    // ** OBJECT USER LOGIN LEVEL
    // ====================================================
    function user_login_level_get_list($filters = array()){
        $this->db->select("*");
        $this->db->from("user_login_level");
        
        foreach ($filters as $key => $value) {
            switch ($key) {
                case "id":
                    $this->db->where("id", (int)$value);
                    break;

                default:
                    break;
            }
        }
        
        $res = $this->db->get()->result_array();
        return $res;
    }

    function user_login_level_delete($id = 0){
        if((int) $id == 0) return 0;
        
        $this->db->where("id", $id);
        $this->db->delete("user_login_level");

        return $id;
    }

    function user_login_level_save($data = array()){
        $id = (int) $data["id"];
        $creator_user_id = (int) $data["creator_user_id"];
        $creator_user_name = trim($data["creator_user_name"]);
        $name = trim($data["name"]);
        $privilege_json = trim($data["privilege_json"]);
        $menu_json = trim($data["menu_json"]);

        $this->db->set(array(
            "id" => $id, 
            "created" => date("Y-m-d H:i:s"),
            "creator_user_id" => $creator_user_id, 
            "creator_user_name" => $creator_user_name, 
            "name" => $name, 
            "privilege_json" => $privilege_json, 
            "menu_json" => $menu_json
        ));
        $this->db->replace("user_login_level");

        if($id == 0) return $this->db->insert_id();
        return $id;
    }
    // ====================================================
    // ** END -- OBJECT USER LOGIN LEVEL
    // ====================================================

    // ====================================================
    // ** OBJECT USER LOGIN MENU
    // ====================================================
    function user_login_menu_get_list($filters = array()){

        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'parent_id_list':
                    if(!is_array($value)) return array();
                    if(count($value) == 0) return array();
                    break;                
                case "is_parent":                    
                    $is_parent = (int)$value;                            
                    if($is_parent < 0 || $is_parent > 1) return array();
                default:
                    break;
            }
        }                    
				
        foreach ($filters as $key => $value) {
            switch ($key) {
                case "id":
                    $this->db->where("id", (int)$value);
                    break;
                case "hash_id":
                    $this->db->where("md5(hash_id)", $value);
                    break;
                case "parent_id":
                    $this->db->where("parent_id", (int)$value);
                    break;
                case "sort":
                    $this->db->where("sort", (int)$value);
                    break;
                case "is_parent": 
                    $is_parent = (int)$value;
                        
                    if($is_parent < 0 || $is_parent > 1) return array();
                    
                    if($is_parent == 1) $this->db->where("id = parent_id");
                    if($is_parent == 0) $this->db->where("id != parent_id");
                    
                    break;

                case "parent_id_list":
                    $this->db->where_in("parent_id", $value);
                    break;
                default:
                    break;
            }
        }
        
        $this->db->select("*");
        $this->db->from("user_login_menu");								
        $this->db->order_by("sort");
				
        $res = $this->db->get()->result_array();
        return $res;
    }

    function user_login_menu_check_if_parent_have_childs($parent_id = 0){
        if((int) $parent_id == 0) return array();
        $sql = "
            select 
                * 
            from 
                user_login_menu
            where
                id = 
        ";
    }

    function user_login_menu_get_new_sort_value($parent_id = 0){
        $this->db->select("count(sort) + 1 as new_sort");
        $this->db->from("user_login_menu");

        if((int) $parent_id > 0){
						$this->db->where("parent_id", $parent_id);
						$this->db->where("parent_id != id");
        }else{
            $this->db->where("parent_id = id");
        }
        $res = $this->db->get()->result_array();

        if(count($res) == 0) return 1;
        $res = $res[0];
        $new_sort = $res["new_sort"];
        if($new_sort == null) return 1;
        return $new_sort;
    }

    function user_login_menu_delete($id = 0){
        if((int) $id == 0) return 0;
        
        $this->db->where("id", $id);
        $this->db->delete("user_login_menu");

        return $id;
    }

    function user_login_menu_save($data = array()){
        $id = (int) $data["id"];
        $creator_user_id = (int) $data["creator_user_id"];
        $creator_user_name = trim($data["creator_user_name"]);
        $title = trim($data["title"]);
        $icon = trim($data["icon"]);
        $link = trim($data["link"]);
        $parent_id = trim($data["parent_id"]);
        $sort = trim($data["sort"]);
        $user_login_menu_group_id = trim($data["user_login_menu_group_id"]);

        $this->db->set(array(
            "id" => $id, 
            "created" => date("Y-m-d H:i:s"),
            "creator_user_id" => $creator_user_id, 
            "creator_user_name" => $creator_user_name, 
            "title" => $title, 
            "icon" => $icon, 
            "link" => $link, 
            "parent_id" => $parent_id, 
            "sort" => $sort, 
            "user_login_menu_group_id" => $user_login_menu_group_id
        ));
        $this->db->replace("user_login_menu");

        if($id == 0){
            $id = $this->db->insert_id();
            
            if($parent_id == 0){
                $this->db->set("parent_id", $id);
                $this->db->where("id", $id);
                $this->db->update("user_login_menu");
            }
        }
        return $id;
    }

    function user_login_menu_update_sort($id = 0, $sort = 0){
			if((int) $id == 0 || (int) $sort == 0) return 0;

			$this->db->set("sort", $sort);
			$this->db->where("id", $id);
			$this->db->update("user_login_menu");

			return $id;
    }
    // ====================================================
    // ** END -- OBJECT USER LOGIN MENU
    // ====================================================
}
