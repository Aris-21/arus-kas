<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alur_kas
 *
 * @author ian
 */
class Alur_kas extends MY_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
        
        model('m_alur_kas', 'alur_kas');
    }
    
    function index(){        
        //-- Index

        view('pages/alur_kas/index');
    }    

    function ajax_get_dashboard_info(){
        //-- Dashboard Info

        $res = $this->alur_kas->alur_kas_get_dashboard_info();

        ob_clean();
        echo json_encode($res);
    }
    
    function ajax_list(){
        //-- List

        $data           = $this->alur_kas->alur_kas_get_list($_GET);      
        $rows_total     = $this->alur_kas->alur_kas_get_total();
        $filtered_total = $this->alur_kas->alur_kas_get_filtered_total($_GET);

        $table_data = array(
            "draw"            => isset($_GET["draw"]) ? (int) $_GET["draw"] : 1, 
            "recordsTotal"    => $rows_total,
            "recordsFiltered" => $filtered_total, 
            "data"            => $data
        );

        ob_clean();
        echo json_encode($table_data);
    }
    
    function ajax_detail($hash_id = ""){
        //-- Detail / Edit
        
        $data = array();
        
        $data['level'] = $this->alur_kas->get_level();
        $data['detail'] = $this->alur_kas->alur_kas_get($hash_id);
        $data['tabungan_list'] = $this->alur_kas->tabungan_get_list();
        $data['kategori_list'] = $this->alur_kas->kategori_get_list();
        view('pages/alur_kas/ajax_detail', $data);
    }
    
    function ajax_view($hash_id = ""){
        //-- View
        
        $data = array();
        
        $data['level'] = $this->alur_kas->get_level();
        $data['detail'] = $this->alur_kas->alur_kas_get($hash_id);
        $data['tabungan_list'] = $this->alur_kas->tabungan_get_list();
        $data['kategori_list'] = $this->alur_kas->kategori_get_list();
        view('pages/alur_kas/ajax_view', $data);
    }

    function cetak(){
        //-- Cetak

        $data = array();
        $data["list"] = $this->alur_kas->alur_kas_get_list_for_print();
        $data["saldo_sebelumnya"] = $this->alur_kas->alur_kas_get_saldo_sebelumnya();

        view('pages/alur_kas/cetak', $data);
    }

    function ajax_save(){
        //-- Save

        $res = $this->alur_kas->alur_kas_save($_POST);

        ob_clean();
        echo json_encode($res);
    }
    
    function ajax_delete($hash_id = ""){
        //-- Delete

        $res = $this->alur_kas->alur_kas_delete($hash_id);

        ob_clean();
        echo json_encode($res);
    }
}
