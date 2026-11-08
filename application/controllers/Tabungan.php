<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tabungan
 *
 * @author ian
 */
class Tabungan extends MY_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
        
        model('m_tabungan', 'tabungan');
    }
    
    function index(){
        //-- Index
        view('pages/tabungan/index');
    }
    
    function ajax_list(){
        //-- List

        $data           = $this->tabungan->tabungan_get_list($_GET);      
        $rows_total     = $this->tabungan->tabungan_get_total();
        $filtered_total = $this->tabungan->tabungan_get_filtered_total($_GET);

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
        //-- Detail
        $data = array();                
        $data['detail'] = $this->tabungan->tabungan_get($hash_id);
        view('pages/tabungan/ajax_detail', $data);
    }
    
    function ajax_save(){
        //-- Save

        $res = $this->tabungan->tabungan_save($_POST);

        ob_clean();
        echo json_encode($res);
    }
    
    function ajax_delete($hash_id = ""){
        //-- Delete

        $res = $this->tabungan->tabungan_delete($hash_id);

        ob_clean();
        echo json_encode($res);
    }
}
