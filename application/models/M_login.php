<?php

class M_login extends MY_Model{
            
    public function __construct(){
        parent::__construct();
    }

    function do_logout(){
        set_session("username", "");
        set_session("password", "");
        set_session("user", array());
        set_session("level", "");
        set_session("allow_menu_list", array());
        set_session("allow_method_list", array());
    }

    function check_login($username = "", $password = ""){
        if(empty($username) || empty($password)) {            
            return set_http_response_error(401, "Log in Gagal");            
        };        

        set_session("username", $username);
        set_session("password", $password);

        
        $password = $this->encrypt_password($password);        
        
        $this->db->select("
            user_login.*,
            user_login_level.name user_login_level_name, 
            user_login_level.privilege_json, 
            user_login_level.menu_json, 
        ");
        $this->db->from("user_login");
        $this->db->join("user_login_level", "user_login_level.id = user_login.user_login_level_id", "left");
        $this->db->where("user_login.username", $username);
        $this->db->where("user_login.password", $password);            
        $res = $this->db->get()->result_array();
        if(count($res) == 0) {
            return set_http_response_error(401, "Log in Gagal");
        }

        $res = $res[0];
                
        $user_login_level_id = (int) $res["user_login_level_id"];
        $privilege_list = json_decode($res["privilege_json"], true);        
        if(!is_array($privilege_list)) $privilege_list = array();
        $menu_list = json_decode($res["menu_json"], true);        
        if(!is_array($menu_list)) $menu_list = array();        
        
        $menu_list = $this->generate_allow_menu_list($menu_list);

        if($res["user_login_level_name"] == "Super Administrator") {
            $menu_list = $this->generate_allow_menu_list_for_super_admin();
        }

        set_session("allow_method_list", $privilege_list);
        set_session("allow_menu_list", $menu_list);
        set_session("user", $res);
        set_session("level", $res["user_login_level_name"]);

        return set_http_response_success("Success");
    }

    function generate_allow_menu_list_for_super_admin(){
        model("m_user_login", "user_login");
        $user_login_menu_list = $this->user_login->user_login_menu_get_list();
                
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

            $allowed_menu_list[$id]["allow"] = 1;
            $allowed_menu_list[$id]["shortcut"] = 1;
            $allowed_menu_list[$id]["child"] = array();

            foreach ($child_list as $c) {
                $child_id = (int) $c["id"];
                $parent_id = (int) $c["parent_id"];

                $menu_allow_key_child_name = "menu-allow-child-$child_id";
                $menu_shortcut_key_child_name = "menu-shortcut-child-$child_id";

                $allowed_menu_list[$id]["child"][$child_id]["title"] = $c["title"];
                $allowed_menu_list[$id]["child"][$child_id]["icon"] = $c["icon"];
                $allowed_menu_list[$id]["child"][$child_id]["link"] = $c["link"];

                $allowed_menu_list[$id]["child"][$child_id]["allow"] = 1;
                $allowed_menu_list[$id]["child"][$child_id]["shortcut"] = 1;
            }
        }        
        return $allowed_menu_list;
    }

    function generate_allow_menu_list($menu_list){
        model("m_user_login", "user_login");
        $user_login_menu_list = $this->user_login->user_login_menu_get_list();                                

        $allowed_menu_list = array();
        foreach ($user_login_menu_list as $p) {
            $id = (int) $p["id"];
            $child_list = $p["child_list"];
            if(!is_array($child_list)) continue;
            
            $allow = 0;
            $shortcut = 0;

            if(!isset($menu_list[$id])) continue;            
            if(isset($menu_list[$id]["allow"])) $allow = (int) $menu_list[$id]["allow"];
            if(isset($menu_list[$id]["shortcut"])) $shortcut = (int) $menu_list[$id]["shortcut"];            
            
            $menu_allow_key_parent_name = "menu-allow-parent-$id";
            $menu_shortcut_key_parent_name = "menu-shortcut-parent-$id";

            $allowed_menu_list[$id]["title"] = $p["title"];
            $allowed_menu_list[$id]["icon"] = $p["icon"];
            $allowed_menu_list[$id]["link"] = $p["link"];

            $allowed_menu_list[$id]["allow"] = $allow;
            $allowed_menu_list[$id]["shortcut"] = $allow;
            $allowed_menu_list[$id]["child"] = array();

            foreach ($child_list as $c) {
                $child_id = (int) $c["id"];
                $parent_id = (int) $c["parent_id"];

                $allow = 0;
                $shortcut = 0;
                if(!isset($menu_list[$id]["child"][$child_id])) continue;
                if(isset($menu_list[$id]["child"][$child_id]["allow"])) $allow = (int) $menu_list[$id]["child"][$child_id]["allow"];
                if(isset($menu_list[$id]["child"][$child_id]["shortcut"])) $shortcut = (int) $menu_list[$id]["child"][$child_id]["shortcut"];
                

                $menu_allow_key_child_name = "menu-allow-child-$child_id";
                $menu_shortcut_key_child_name = "menu-shortcut-child-$child_id";

                $allowed_menu_list[$id]["child"][$child_id]["title"] = $c["title"];
                $allowed_menu_list[$id]["child"][$child_id]["icon"] = $c["icon"];
                $allowed_menu_list[$id]["child"][$child_id]["link"] = $c["link"];

                $allowed_menu_list[$id]["child"][$child_id]["allow"] = $allow;
                $allowed_menu_list[$id]["child"][$child_id]["shortcut"] = $shortcut;
            }
        }        
        return $allowed_menu_list;
    }
}