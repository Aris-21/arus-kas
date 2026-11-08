<?php 

class Login extends MY_Controller{

    private $is_ajax;

    public function __construct(){
        parent::__construct();

        model("m_login", "login");

        $this->is_ajax = false;
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && trim($_SERVER["HTTP_X_REQUESTED_WITH"]) == "XMLHttpRequest"){
            $this->is_ajax = true;
        }        
    }

    function index(){
        //-- Index
        view("pages/login/index");
    }

    function do_login(){   
        //-- Do Login     
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        $res = $this->login->check_login($username, $password);        
        if(!$this->is_ajax) redirect_url("");
        
        ob_clean();
        echo json_encode($res);        
    }

    function do_logout(){
        //-- Do Logout
        $this->login->do_logout();
        redirect_url("login");
    }
}