<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kategori
 *
 * @author ian
 */
class Kategori extends MY_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
        
        model('m_kategori', 'kategori');
    }
    
    function index(){
        //-- Index
        view('pages/kategori/index');
    }
    
    function ajax_list(){
        //-- List

        $data           = $this->kategori->kategori_get_list($_GET);      
        $rows_total     = $this->kategori->kategori_get_total();
        $filtered_total = $this->kategori->kategori_get_filtered_total($_GET);

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
        $data['detail'] = $this->kategori->kategori_get($hash_id);
        view('pages/kategori/ajax_detail', $data);
    }
    
    function ajax_save(){
        //-- Save

        $res = $this->kategori->kategori_save($_POST);

        ob_clean();
        echo json_encode($res);
    }
    
    function ajax_delete($hash_id = ""){
        //-- Delete

        $res = $this->kategori->kategori_delete($hash_id);

        ob_clean();
        echo json_encode($res);
    }
}
