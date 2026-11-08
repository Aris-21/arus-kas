<?php

/*
 * MY_Controller
 *
 * Base Controller aplikasi.
 */

class MY_Controller extends CI_Controller
{
    private $member_user_data;
    private $is_ajax;


    public function __construct()
    {
        parent::__construct();

        model('m_login', 'login');


        /*
         * =====================================================
         * DEBUG PASSWORD
         * =====================================================
         *
         * Jangan aktifkan pada production.
         *
         * Contoh:
         *
         * echo $this->login->encrypt_password("password");
         *
         */


        $this->is_ajax = false;

        $this->member_user_data = array();


        /*
         * =====================================================
         * DETEKSI AJAX
         * =====================================================
         */

        if (
            isset($_SERVER["HTTP_X_REQUESTED_WITH"])
            &&
            strtolower(
                trim(
                    $_SERVER["HTTP_X_REQUESTED_WITH"]
                )
            ) == "xmlhttprequest"
        ) {

            $this->is_ajax = true;
        }


        /*
         * =====================================================
         * CHECK LOGIN
         * =====================================================
         */

        $uri_segment_1 =
            trim(
                $this->uri->segment(1)
            );


        if ($uri_segment_1 != "login") {

            $this->check_login();

        }
    }


    /* =========================================================
       CHECK LOGIN
       ========================================================= */

    protected function check_login()
    {
        /*
         * Jangan lakukan pengecekan pada
         * controller login.
         */

        if (
            trim(
                $this->uri->segment(1)
            ) == "login"
        ) {

            return true;
        }


        /* =====================================================
           GET SESSION LOGIN
           ===================================================== */

        $username =
            get_session("username");

        $password =
            get_session("password");


        /*
         * Validasi ulang user berdasarkan session.
         */

        $res =
            $this->login->check_login(
                $username,
                $password
            );


        /* =====================================================
           LOGIN TIDAK VALID
           ===================================================== */

        if (
            !isset($res["is_success"])
            ||
            (int)$res["is_success"] == 0
        ) {

            /*
             * Request biasa diarahkan ke login.
             */

            if (!$this->is_ajax) {

                redirect_url("login");

                exit;
            }


            /*
             * AJAX mengembalikan JSON.
             */

            $this->json_error(
                401,
                "Silakan login kembali"
            );
        }


        /* =====================================================
           CONTROLLER & FUNCTION
           ===================================================== */

        $controller_name =
            trim(
                $this->uri->segment(1)
            );


        $function_name =
            trim(
                $this->uri->segment(2)
            );


        if (empty($controller_name)) {

            $controller_name =
                $this->router
                    ->default_controller;
        }


        if (empty($function_name)) {

            $function_name = "index";
        }


        /*
         * Normalisasi nama.
         */

        $controller_name =
            strtolower($controller_name);

        $function_name =
            strtolower($function_name);


        /* =====================================================
           USER LEVEL
           ===================================================== */

        $level =
            trim(
                get_session("level")
            );


        /*
         * =====================================================
         * SUPER ADMINISTRATOR
         * =====================================================
         *
         * Super Administrator mempunyai
         * akses penuh.
         */

        if (
            strcasecmp(
                $level,
                "Super Administrator"
            ) == 0
        ) {

            return true;
        }


        /*
         * =====================================================
         * ADMINISTRATOR
         * =====================================================
         *
         * Administrator diizinkan mengelola
         * User Login.
         *
         * Tetapi Administrator TIDAK otomatis
         * memperoleh akses terhadap:
         *
         * - User Level
         * - User Menu
         * - konfigurasi privilege
         *
         * Area tersebut tetap mengikuti
         * privilege/Super Administrator.
         */

        if (
            strcasecmp(
                $level,
                "Administrator"
            ) == 0
        ) {

            /*
             * Method User Login yang boleh
             * digunakan Administrator.
             */

            $administrator_user_login_methods =
                array(

                    "index",

                    "ajax_list",

                    "ajax_detail",

                    "ajax_save",

                    "ajax_delete",

                    "ajax_reset_password",

                    "ajax_get_employee_name_for_employee_number_formatted",

                    "ajax_change_password"

                );


            if (
                $controller_name == "user_login"
                &&
                in_array(
                    $function_name,
                    $administrator_user_login_methods
                )
            ) {

                return true;
            }
        }


        /* =====================================================
           CHECK PRIVILEGE NORMAL
           ===================================================== */

        $allow_method_list =
            get_session(
                "allow_method_list"
            );


        /*
         * Pastikan session privilege berupa array.
         */

        if (
            !is_array(
                $allow_method_list
            )
        ) {

            $allow_method_list =
                array();
        }


        $allowed =
            $this->check_method_privilege(
                $allow_method_list,
                $controller_name,
                $function_name
            );


        /* =====================================================
           ACCESS DENIED
           ===================================================== */

        if (!$allowed) {

            $this->access_denied(
                $function_name
            );
        }


        return true;
    }


    /* =========================================================
       CHECK METHOD PRIVILEGE
       ========================================================= */

    private function check_method_privilege(
        $allow_method_list,
        $controller_name,
        $function_name
    ) {

        /*
         * Controller tidak ditemukan
         * dalam privilege.
         */

        if (
            !isset(
                $allow_method_list[
                    $controller_name
                ]
            )
        ) {

            return false;
        }


        $controller_privilege =
            $allow_method_list[
                $controller_name
            ];


        /*
         * Pastikan privilege controller
         * berbentuk array.
         */

        if (
            !is_array(
                $controller_privilege
            )
        ) {

            return false;
        }


        /*
         * =====================================================
         * ROOT ACCESS
         * =====================================================
         *
         * root = 1 berarti semua function
         * pada controller diizinkan.
         */

        if (
            isset(
                $controller_privilege["root"]
            )
            &&
            (int)$controller_privilege["root"] == 1
        ) {

            return true;
        }


        /*
         * =====================================================
         * METHOD ACCESS
         * =====================================================
         */

        if (
            !isset(
                $controller_privilege[
                    $function_name
                ]
            )
        ) {

            return false;
        }


        $method_privilege =
            $controller_privilege[
                $function_name
            ];


        /*
         * Format privilege:
         *
         * ['allow'] => 1
         */

        if (
            is_array(
                $method_privilege
            )
            &&
            isset(
                $method_privilege["allow"]
            )
            &&
            (int)$method_privilege["allow"] == 1
        ) {

            return true;
        }


        return false;
    }


    /* =========================================================
       ACCESS DENIED
       ========================================================= */

    private function access_denied(
        $function_name = ""
    ) {

        /*
         * AJAX function.
         */

        if (
            $this->is_ajax
            ||
            substr(
                $function_name,
                0,
                4
            ) == "ajax"
        ) {

            $this->json_error(
                403,
                "Akses ditolak"
            );
        }


        /*
         * Request biasa.
         */

        redirect_url(
            "error_page/error_403"
        );

        exit;
    }


    /* =========================================================
       JSON ERROR
       ========================================================= */

    private function json_error(
        $code,
        $message
    ) {

        if (
            ob_get_length()
        ) {

            ob_clean();
        }


        $res =
            set_http_response_error(
                $code,
                $message
            );


        header(
            "Content-Type: application/json; charset=utf-8"
        );


        echo json_encode($res);

        exit;
    }
}