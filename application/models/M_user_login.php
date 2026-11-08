<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_user_login
 *
 * @author ian
 */
class M_user_login extends MY_Model {
    //put your code here
    
    private $user_engine;
    private $actor_user_id;
    private $actor_user_name;
    private $level;
    public function __construct() {
        parent::__construct();
        $this->user_engine = new User_engine();

        $user = get_session("user");
        $level = get_session("level");
        $this->actor_user_id = isset($user["id"]) ? (int) $user["id"] : 0;
        $this->actor_user_name = isset($user["user_name"]) ? $user["user_name"] : "";
    }
    
    // ===============================================
    // ** OBJECT USER LOGIN
    // ===============================================
    function user_login_get_list($filters = array()){
        $res = $this->user_engine->user_login_get_list($filters);        
        $final_res = array();
        foreach ($res as $r) {
            if(trim($r['user_login_level_name'] == "Super Administrator")) continue;
            $final_res[] = $r;
        }
        
        return $final_res;
    }
    
    function user_login_get($hash_id = ""){
        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login");
        if($id == 0){
            return array();
        }        
        
        $filters = array(
            "id" => $id
        );
        $res = $this->user_engine->user_login_get_list($filters);
        if(count($res) == 0) return array();
        
        $res = $res[0];                
        return $res;
    }
    
    function user_login_change_password($post = array()){
        if(!is_array($post) || count($post) == 0) return set_http_response_error(201, "Invalid Input");
        
        $user = get_session("user");
        $user_id = (int) $user["id"];
        if($user_id == 0) return set_http_response_error(401, "Invalid Login");
        $old_password = trim($this->input->post("old_password"));
        $new_password = trim($this->input->post("new_password"));
        $confirm_password = trim($this->input->post("confirm_password"));
        
        $filters = array();
        $filters["id"]= $user_id;
        $res = $this->user_engine->user_login_get_list($filters);
        if(count($res)== 0) return set_http_response_error(201, "Invalid User");
        $res = $res[0];
        $current_password = trim($res["password"]);
        $old_password = $this->encrypt_password($old_password);
                
        if($old_password != $current_password){
            return set_http_response_error(201, "Invalid old password");
        }
        
        if($new_password != $confirm_password){
            return set_http_response_error(201, "New password does not match");
        }
        
        $password = $this->encrypt_password($new_password);
        
        $this->db->trans_begin();
        try {                    
            $res = $this->user_engine->user_login_update_password($user_id, $password);
            if($res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "Failed to change password #001");
            } 

            set_session("password", $new_password); // tanpa encrypt

            $this->db->trans_commit();
            return set_http_response_success("Password has been changed");
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Failed to change password #002");
        }
    }
    
    function user_login_delete($hash_id = ""){
//        if(!$this->is_superadmin()) return set_http_response_error(401, "Access denied");
        
        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login");
        if($id == 0){
            return set_http_response_error(201, "Unknown user login");
        }        
        
        $this->db->trans_begin();
        try{
            $res = $this->user_engine->user_login_delete($id);
            if((int) $res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "Failed to delete user login #1");
            }

            $this->db->trans_commit();
            return set_http_response_success("User deleted");
        }catch(Exception $e){
            $this->db->trans_rollback();
            return set_http_response_error(201, "Failed to delete user login #2");
        }
    }
    
    function user_login_save($post = array()){
        
        $hash_id = trim($post['hash_id']);     
        $user_login_level_hash_id = trim($post['user_login_level_hash_id']);
        $name = trim($this->input->post("name"));
        $username = trim($this->input->post("username"));

        if(empty($name)) return set_http_response_error(201, "Empty name");
        if(empty($username)) return set_http_response_error(201, "Empty username");


        $id = 0;
        if(!empty($hash_id)){
            $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login");
            if($id == 0){
                return set_http_response_error(401, "Invliad User Login");
            }      
        }      

        // **
        // check duplicate username
        $filters = array();
        $filters["username"] = $username;
        $res = $this->user_engine->user_login_get_list($filters);
        if(count($res) > 0){
            $res = $res[0];
            $curr_id = (int) $res["id"];
            if($curr_id != $id) return set_http_response_error(201, "Username has been registered");
        }

        $user_login_level_id = $this->user_engine->get_id_by_hash_id($user_login_level_hash_id, "user_login_level");
        if((int) $user_login_level_id == 0) return set_http_respone_error(201, "Invalid User Login Level");                
        
        $password = "";
        if($id == 0){
            $password = trim($post['password']);
            $retype_password = trim($post['retype_password']);
            if($password !=  $retype_password){
                return set_http_response_error(201, "Password does not match");
            }
            
            $password = $this->encrypt_password($password);
        }else{
            $filters = array(
                "id" => $id
            );
            $res = $this->user_engine->user_login_get_list($filters);
            $res = $res[0];
            $password = trim($res['password']);
        }                        
        
        $data = array();
        $data['id'] = $id;
        $data["creator_user_id"] = $this->actor_user_id;
        $data["creator_user_name"] = $this->actor_user_name;
        $data['name'] = trim($name);
        $data['username'] = trim($username);
        $data['password'] = trim($password);
        $data['user_login_level_id'] = $user_login_level_id;
        
        $this->db->trans_begin();
        try{
            $res = $this->user_engine->user_login_save($data);
            if((int) $res == 0) {
                $this->db->trans_rollback();
                return set_http_response_error(201, "Failed to save user login");
            }


            $this->db->trans_commit();
            return set_http_response_success("User login saved");
        }catch(Exception $e){
            $this->db-trans_rollback();
            return set_http_response_error(201, "Failed to save user login");
        }
    }
    
    function user_login_reset_password($post = array()){
        $hash_id = $this->input->post("hash_id"); 
        $password = $this->input->post("password"); 
        $retype_password = $this->input->post("retype_password");

        if(empty($password)) return set_http_response_error(201, "Empty password");
        if(empty($retype_password)) return set_http_response_error(201, "Empty retype password");

        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login");
        if($id == 0) return set_http_response_error(401, "Invliad User Login");

        if($password !=  $retype_password) return set_http_response_error(201, "Password does not match");

        $password = $this->encrypt_password($password);

        $this->db->trans_begin();
        try{

            $res = $this->user_engine->user_login_update_password($id, $password);
            if((int) $res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "Failed to reset password");
            }

            $this->db->trans_commit();
            return set_http_response_success("Password has been reset");
        }catch(Exception $e){
            $this->db->trans_rollback();
            return set_http_response_error(201, "Failed to reset password");
        }
    }

    function set_user_privilege($post){
        // set user privilege
        $method_list = get_all_method_for_each_controllers("admin");        
        $allowed_method_list = array();
        foreach ($method_list as $controller_name => $method_data) {
            $allowed_method_list[$controller_name] = $method_data;
            $privilege_parent_key_name = "privilege-$controller_name";
            $privilege_parent_item_name = "privilege-$controller_name-item";
            
            $is_parent_checked = false;
            
            // if parent checked
            if(isset($post[$privilege_parent_key_name])){
                $is_parent_checked = true;                
            }
            
            // if item !checked but item_checked = total total function in its controller
            if(isset($post[$privilege_parent_item_name])){
                if(count($post[$privilege_parent_item_name]) == count($method_data)){
                    $is_parent_checked == true;
                }
            }
                        
            $allowed_method_list[$controller_name]['root'] = 0;
            if($is_parent_checked){
                $allowed_method_list[$controller_name]['root'] = 1;
            }
                        
            foreach ($method_data as $function_name => $data) {
                if(isset($post[$privilege_parent_item_name]) && count($post[$privilege_parent_item_name])> 0){
                    foreach ($post[$privilege_parent_item_name] as $index => $checked_name) {
                        if($function_name == $checked_name){
                            $allowed_method_list[$controller_name][$function_name]['allow'] = 1;
                        }
                    }
                }else{
                    // if item !checekd bu parent is checked, then check its function
                    if($is_parent_checked){                                
                        $allowed_method_list[$controller_name][$function_name]['allow'] = 1;
                    }
                }
            }
        }
        
        return $allowed_method_list;
    }

    // ===============================================
    // ** OBJECT USER LOGIN LEVEL
    // ===============================================
    function user_login_level_get_list($filters = array()){
        $res = $this->user_engine->user_login_level_get_list($filters);

        $final_res = array();
        foreach($res as $r){
            if(trim($r["name"] == "Super Administrator")) continue;

            $final_res[] = $r;
        }

        return $final_res;
    }

    function user_login_level_get($hash_id = ""){
        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login_level");
        
        $filters = array();
        $filters["id"] = $id;
        $res = $this->user_engine->user_login_level_get_list($filters);
        if(count($res) == 0) return array();
        $res = $res[0];

        return $res;
    }

    function user_login_level_delete($hash_id = ""){
        // tolak jika yang akses bukan superadmin
        if(!$this->is_superadmin()) return set_http_response_error(401, "Access denied");

        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login_level");
        
        $filters = array();
        $filters["id"] = $id;
        $res = $this->user_engine->user_login_level_get_list($filters);
        if(count($res) == 0) return set_http_response_error(201, "Invalid user login level");
        $res = $res[0];
        $name = $res["name"];
        if(trim($name) == "Super Administrator") return set_http_response_error(401, "Access denied");

        // **
        // check jika user login level tidak digunakan
        $filters = array();
        $filters["user_login_level_id"] = $id;
        $res = $this->user_engine->user_login_get_list($filters);
        if(count($res) > 0) return set_http_response_error(201, "Level ini sedang digunakan pada user login");

        $this->db->trans_begin();
        try {            
            $res = $this->user_engine->user_login_level_delete($id);
            if((int) $res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "User level gagal dihapus #001");
            }
            
            $this->db->trans_commit();
            return set_http_response_success("User level telah dihapus");

        } catch (Throwable $th) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "User level gagal dihapus #002");
        }
    }

    function user_login_level_save($post = array()){                
        // tolak jika yang akses bukan superadmin
        if(!$this->is_superadmin()) return set_http_response_error(401, "Access denied");

        $hash_id = trim($this->input->post("hash_id"));
        $name = trim($this->input->post("name"));
        
        
        $privilege_list = $this->user_login_level_get_privilege_list($post);
        $menu_list = $this->user_login_level_get_menu_list($post);

        // **
        // jika edit (hash id  != '') : 
        // -- check jika id valid
        // -- check jika level != Super Administrator
        $id = 0;
        if(!empty($hash_id)){
            $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login_level");            

            $filters = array();
            $filters["id"] = $id;
            $res = $this->user_engine->user_login_level_get_list($filters);
            if(count($res) == 0) return set_http_response_error(201, "Invalid User login level");
            $res = $res[0];
            $curr_name = trim($res["name"]);
            if($curr_name == "Super Administrator") return set_http_response_error(401, "Access denied");
        }        

        if(empty($name)) return set_http_response_error(201, "Nama tidak boleh kosong");
        if($name == "Super Administrator") return set_http_response_error(401, "Akses ditolak");
        if(count($privilege_list) == 0) return set_http_response_error(201, "Akses modul belum dipilih");
        if(count($menu_list) == 0) return set_http_response_error(201, "Akses menu belum dipilih");
        
        $data = array();
        $data["id"] = $id;
        $data["creator_user_id"] = $this->actor_user_id;
        $data["creator_user_name"] = $this->actor_user_name;        
        $data["name"] = $name;
        $data["privilege_json"] = json_encode($privilege_list);
        $data["menu_json"] = json_encode($menu_list);

        $this->db->trans_begin();
        try {
            $res = $this->user_engine->user_login_level_save($data);
            if((int) $res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "Gagal menyimpan user level #001");
            } 

            if($id == 0) $id = $res;

            $this->db->trans_commit();
            return set_http_response_success("User level telah disimpan", array(), md5($id));
        } catch (Exceptio $e) {        
            $this->db->trans_rollback();
            return set_http_response_error(201, "Gagal menyimpan user level #002");
        }
    }
    
    function user_login_level_get_privilege_list($post = array()){
        if(!is_array($post)) return array();
        if(count($post) == 0) return array();

        // set user privilege
        $method_list = get_all_method_for_each_controllers();        
        $allowed_method_list = array();
        foreach ($method_list as $controller_name => $method_data) {
            $allowed_method_list[$controller_name] = $method_data;
            $privilege_parent_key_name = "privilege-$controller_name";
            $privilege_parent_item_name = "privilege-$controller_name-item";
            
            $is_parent_checked = false;
            
            // if parent checked
            if(isset($post[$privilege_parent_key_name])){                
                $is_parent_checked = true;                
            }
            
            // if parent item !checked but item_checked = total function in its controller
            if(isset($post[$privilege_parent_item_name])){
                if(count($post[$privilege_parent_item_name]) == count($method_data)){
                    $is_parent_checked == true;
                }
            }
                        
            $allowed_method_list[$controller_name]['root'] = 0;
            if($is_parent_checked){
                $allowed_method_list[$controller_name]['root'] = 1;
            }
                        
            foreach ($method_data as $function_name => $data) {
                if(isset($post[$privilege_parent_item_name]) && count($post[$privilege_parent_item_name])> 0){
                    foreach ($post[$privilege_parent_item_name] as $index => $checked_name) {
                        if($function_name == $checked_name){
                            $allowed_method_list[$controller_name][$function_name]['allow'] = 1;
                        }
                    }
                }else{
                    // if item !checked but parent is checked, then check its function
                    if($is_parent_checked){                                
                        $allowed_method_list[$controller_name][$function_name]['allow'] = 1;
                    }
                }
            }
        }        
        
        return $allowed_method_list;
    }
    
    function user_login_level_get_menu_list($post = array()){
        if(!is_array($post)) return array();
        if(count($post) == 0) return array();

        $user_login_menu_list = $this->user_login_menu_get_list();
                
        $allowed_menu_list = array();
        foreach ($user_login_menu_list as $p) {
            $id = (int) $p["id"];
            $child_list = $p["child_list"];
            if(!is_array($child_list)) continue;
            
            $menu_allow_key_parent_name = "menu-allow-parent-$id";
            $menu_shortcut_key_parent_name = "menu-shortcut-parent-$id";

            $allowed_menu_list[$id]["title"] = $p["title"];
            $allowed_menu_list[$id]["icon"] = $p["icon"];
            $allowed_menu_list[$id]["link"] = $p["link"];

            $allowed_menu_list[$id]["allow"] = 0;
            $allowed_menu_list[$id]["shortcut"] = 0;
            $allowed_menu_list[$id]["child"] = array();

            if(isset($post[$menu_allow_key_parent_name])){
                if($post[$menu_allow_key_parent_name] == true) {
                    $allowed_menu_list[$id]["allow"] = 1;

                    if(isset($post[$menu_shortcut_key_parent_name])){
                        if($post[$menu_shortcut_key_parent_name] == true) {
                            $allowed_menu_list[$id]["shortcut"] = 1;
                        }
                    }
                }
            }

            foreach ($child_list as $c) {
                $child_id = (int) $c["id"];
                $parent_id = (int) $c["parent_id"];

                $menu_allow_key_child_name = "menu-allow-child-$child_id";
                $menu_shortcut_key_child_name = "menu-shortcut-child-$child_id";

                $allowed_menu_list[$id]["child"][$child_id]["title"] = $c["title"];
                $allowed_menu_list[$id]["child"][$child_id]["icon"] = $c["icon"];
                $allowed_menu_list[$id]["child"][$child_id]["link"] = $c["link"];

                $allowed_menu_list[$id]["child"][$child_id]["allow"] = 0;
                $allowed_menu_list[$id]["child"][$child_id]["shortcut"] = 0;

                if(isset($post[$menu_allow_key_child_name])){
                    if($post[$menu_allow_key_child_name] == true){
                        $allowed_menu_list[$id]["child"][$child_id]["allow"] = 1;
                        if($parent_id == $id) {
                            $allowed_menu_list[$id]["allow"] = 1;
                        }

                        if(isset($post[$menu_shortcut_key_child_name])){
                            if($post[$menu_shortcut_key_child_name] == true){
                                $allowed_menu_list[$id]["child"][$child_id]["shortcut"] = 1;

                                if($parent_id == $id) {
                                    if($allowed_menu_list[$id]["allow"] == 1){
                                      $allowed_menu_list[$id]["shortcut"] = 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }        
        return $allowed_menu_list;
        // set user privilege
        $method_list = get_all_method_for_each_controllers();        
        $allowed_method_list = array();
        foreach ($method_list as $controller_name => $method_data) {
            $allowed_method_list[$controller_name] = $method_data;
            $privilege_parent_key_name = "privilege-$controller_name";
            $privilege_parent_item_name = "privilege-$controller_name-item";
            
            $is_parent_checked = false;
            
            // if parent checked
            if(isset($post[$privilege_parent_key_name])){                
                $is_parent_checked = true;                
            }
            
            // if parent item !checked but item_checked = total function in its controller
            if(isset($post[$privilege_parent_item_name])){
                if(count($post[$privilege_parent_item_name]) == count($method_data)){
                    $is_parent_checked == true;
                }
            }
                        
            $allowed_method_list[$controller_name]['root'] = 0;
            if($is_parent_checked){
                $allowed_method_list[$controller_name]['root'] = 1;
            }
                        
            foreach ($method_data as $function_name => $data) {
                if(isset($post[$privilege_parent_item_name]) && count($post[$privilege_parent_item_name])> 0){
                    foreach ($post[$privilege_parent_item_name] as $index => $checked_name) {
                        if($function_name == $checked_name){
                            $allowed_method_list[$controller_name][$function_name]['allow'] = 1;
                        }
                    }
                }else{
                    // if item !checked but parent is checked, then check its function
                    if($is_parent_checked){                                
                        $allowed_method_list[$controller_name][$function_name]['allow'] = 1;
                    }
                }
            }
        }        
        
        return $allowed_method_list;
    }

    // ===============================================
    // ** END -- OBJECT USER LOGIN LEVEL
    // ===============================================

    // ===============================================
    // ** OBJECT USER LOGIN MENU
    // ===============================================
    function user_login_menu_get_list($filters = array()){

        // **
        // get parent list
        $filters = array();
        $filters["is_parent"] = 1;
        $parent_list = $this->user_engine->user_login_menu_get_list($filters);        
        if(count($parent_list) == 0) return array();

        // generate parent id list
        $parent_id_list = array();
        foreach ($parent_list as $l) {
            if((int) $l["id"] != (int) $l["parent_id"]) continue;
            $parent_id_list[] = (int) $l["id"];
        }        

        // get menu list for parent_id_list
        $filters = array();
        $filters["is_parent"] = 0;
        $filters["parent_id_list"] = $parent_id_list;
        $child_list = $this->user_engine->user_login_menu_get_list($filters);

        $final_res = array();
        foreach ($parent_list as $p) {
            $id = (int) $p["id"];
            $row = $p;
            $row["child_list"] = array();

            foreach ($child_list as $c) {
                $parent_id = (int) $c["parent_id"];
                if($parent_id != $id) continue;

                $row["child_list"][] = $c;
            }

            $final_res[] = $row;
        }
        
        return $final_res;
    }

    function user_login_menu_get_parent_list($filters = array()){
        $filters = array();
        $filters["is_parent"] = 1;
        $res = $this->user_engine->user_login_menu_get_list($filters);
        return $res;
    }

    function user_login_menu_get($hash_id = ""){
        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login_menu");
        
        $filters = array();
        $filters["id"] = $id;
        $res = $this->user_engine->user_login_menu_get_list($filters);
        if(count($res) == 0) return array();
        $res = $res[0];

        return $res;
    }

    function user_login_menu_delete($hash_id = ""){
        // tolak jika yang akses bukan superadmin
        if(!$this->is_superadmin()) return set_http_response_error(401, "Akses ditolak");
        
        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login_menu");
        if((int) $id == 0) return set_http_response_error(201, "Invalid User login menu");

        $is_parent = false;
        // ** 
        // check if parent
        $filters = array();
        $filters["id"] = $id;
        $res = $this->user_engine->user_login_menu_get_list($filters);
        if(count($res) == 0) return set_http_response_error(201, "Invalid menu");
        $res = $res[0];
        $parent_id = (int) $res["parent_id"];
        $is_parent = $parent_id == $id;                

        if($is_parent){
            // **
            // check if has child
            $filters = array();
            $filters["parent_id"] = $id;
            $filters["is_parent"] = 0;
            $res = $this->user_engine->user_login_menu_get_list($filters);            
            if(count($res) > 0) return set_http_response_error(201, "Delete the child first $id: " . count($res));
        }

        $this->db->trans_begin();
        try {            
            $res = $this->user_engine->user_login_menu_delete($id);
            if((int) $res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "Menu gagal dihapus #001");
            }
            
            $this->db->trans_commit();
            return set_http_response_success("Menu telah dihapus");

        } catch (Throwable $th) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Menu gagal dihapus #002");
        }
    }

    function user_login_menu_save($post = array()){
        // tolak jika yang akses bukan superadmin
        if(!$this->is_superadmin()) return set_http_response_error(401, "Akses ditolak");
        
        $hash_id = trim($this->input->post("hash_id"));
        $title = trim($this->input->post("title"));                 
        $icon = trim($this->input->post("icon"));                 
        $link = trim($this->input->post("link"));                 
        $parent_hash_id = trim($this->input->post("parent_hash_id"));
 

        // **
        // jika edit (hash id  != '') : 
        // -- check jika id valid
        $id = 0;
        $sort = 0;
        if(!empty($hash_id)){
            $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login_menu");            
            if((int) $id == 0) return set_http_response_error(201, "Invalid Menu");

            // ** 
            // get current sort
            $filters = array();
            $filters["id"] = $id;
            $res = $this->user_engine->user_login_menu_get_list($filters);
            if(count($res) == 0) return set_http_response_error(201, "Invalid Menu");
            $res = $res[0];
            $sort = (int) $res["sort"];
        }        

        $parent_id = 0;
        if(!empty($parent_hash_id)){
            $parent_id = $this->user_engine->get_id_by_hash_id($parent_hash_id, "user_login_menu");
            if((int) $parent_id == 0) return set_http_response_error(201, "Invalid Parent Menu");
        }        

        if($id != 0 && $parent_id == 0) $parent_id = $id;
        

        // ** 
        // mendapatkan nilai terbesar sort berdasarkan parent id
        if($id == 0) $sort = $this->user_engine->user_login_menu_get_new_sort_value($parent_id);

        if(empty($title)) return set_http_response_error(201, "Nama tidak boleh kosong");
        // if(empty($link)) return set_http_response_error(201, "Link tidak boleh kosong");

        $data = array();
        $data["id"] = $id;
        $data["creator_user_id"] = $this->actor_user_id;
        $data["creator_user_name"] = $this->actor_user_name;        
        $data["title"] = $title;
        $data["icon"] = $icon;
        $data["link"] = $link;
        $data["parent_id"] = $parent_id;
        $data["sort"] = $sort;
        $data["user_login_menu_group_id"] = 0;
        
        $this->db->trans_begin();
        try {
            $res = $this->user_engine->user_login_menu_save($data);
            if((int) $res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "Gagal menyimpan menu #001");
            } 

            $this->db->trans_commit();
            return set_http_response_success("Menu telah disimpan");
        } catch (Exception $th) {        
            $this->db->trans_rollback();
            return set_http_response_error(201, "Gagal menyimpan menu #002: " . $th->getMessage());
        }
    }

    function user_login_menu_update_sort_up($hash_id = ""){        
        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login_menu");
        if((int) $id == 0) return set_http_response_error(201, "Invalid Menu");

        $filters = array();
        $filters["id"] = $id;
        $res = $this->user_engine->user_login_menu_get_list($filters);
        if(count($res) == 0) return set_http_response_error(201, "Invalid menu");
        $res = $res[0];
        $current_sort = (int) $res["sort"];
        $parent_id = (int) $res["parent_id"];

        $is_parent = 0;
        if($parent_id == $id){
            $is_parent = 1;
        }

        if($current_sort > 0){
            $sort = $current_sort - 1;

            // get menu above;
            $filters = array();
            if($is_parent){
                $filters = array(
                    "is_parent" => 1,
                    "sort" => $sort
                );
            }else{
                $filters = array(
                    "is_parent" => 0,
                    "parent_id" => $parent_id,
                    "sort" => $sort
                );
            }
            if(count($filters) == 0) return set_http_response_error(201, " Failed #001");
            $res = $this->user_engine->user_login_menu_get_list($filters);
            $res = $res[0];
            $above_id = (int) $res["id"];
            $this->db->trans_begin();
            try {
                // **
                // set up
                $res = $this->user_engine->user_login_menu_update_sort($id, $sort);
                if((int) $res == 0){
                    $this->db->trans_rollback();
                    return set_http_response_error(201, "Failed to set order #001");
                }
     
                // **
                // set down
                $res = $this->user_engine->user_login_menu_update_sort($above_id, $current_sort);
                if((int) $res == 0){
                    $this->db->trans_rollback();
                    return set_http_response_error(201, "Failed to set order #002 $above_id");
                }
     
                $this->db->trans_commit();
                return set_http_response_success("Success");
            } catch (Exception $e) {
                $this->db->trans_rollback();
                return set_http_response_error(201, "Failed to set order #003");
            }
        }else{
            return set_http_response_success("Success");
        }        
    }

    function user_login_menu_update_sort_down($hash_id = ""){        
        $id = $this->user_engine->get_id_by_hash_id($hash_id, "user_login_menu");
        if((int) $id == 0) return set_http_response_error(201, "Invalid Menu");

        $filters = array();
        $filters["id"] = $id;
        $res = $this->user_engine->user_login_menu_get_list($filters);
        if(count($res) == 0) return set_http_response_error(201, "Invalid menu");
        $res = $res[0];
        $current_sort = (int) $res["sort"];
        $parent_id = (int) $res["parent_id"];
        $sort = $current_sort +1;

        $is_parent = 0;
        if($parent_id == $id){
            $is_parent = 1;
        }

        // get menu below;
        $filters = array();
        if($is_parent){
            $filters = array(
                "is_parent" => 1,
                "sort" => $sort
            );
        }else{
            $filters = array(
                "is_parent" => 0,
                "parent_id" => $parent_id,
                "sort" => $sort
            );
        }
        if(count($filters) == 0) return set_http_response_error(201, " Failed #001");
        $res = $this->user_engine->user_login_menu_get_list($filters);
        $res = $res[0];
        $below_id = (int) $res["id"];

        $this->db->trans_begin();
        try {
            // **
            // set down
            $res = $this->user_engine->user_login_menu_update_sort($id, $sort);
            if((int) $res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "Failed to set order #001");
            }
 
            // **
            // set up
            $res = $this->user_engine->user_login_menu_update_sort($below_id, $current_sort);
            if((int) $res == 0){
                $this->db->trans_rollback();
                return set_http_response_error(201, "Failed to set order #002");
            }
 
            $this->db->trans_commit();
            return set_http_response_success("Success");
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Failed to set order #003");
        }        
    }
    // ===============================================
    // ** END -- OBJECT USER LOGIN MENU
    // ===============================================
}
