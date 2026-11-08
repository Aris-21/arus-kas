<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transfer
 *
 * @author ian
 */
class Transfer extends MY_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
        model('m_transfer', 'transfer');
    }
    
    function index(){     
        //-- Index   

        view('pages/transfer/index');
    }
    
    function ajax_list(){
        //-- List
        
        $data           = $this->transfer->transfer_get_list($_GET);      
        $rows_total     = $this->transfer->transfer_get_total();
        $filtered_total = $this->transfer->transfer_get_filtered_total($_GET);

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
        
        $data['detail'] = $this->transfer->transfer_get($hash_id);
        $data['tabungan_list'] = $this->transfer->tabungan_get_list();
        view('pages/transfer/ajax_detail', $data);
    }
    
    function ajax_view($hash_id = ""){
        //-- View

        $data = array();
        
        $data['detail'] = $this->transfer->transfer_get($hash_id);
        $data['tabungan_list'] = $this->transfer->tabungan_get_list();
        view('pages/transfer/ajax_view', $data);
    }
    
    function ajax_save(){
        //-- Save

        $res = $this->transfer->transfer_save($_POST);

        ob_clean();
        echo json_encode($res);
    }
    
    function ajax_delete($hash_id = ""){
        //-- Delete

        $res = $this->transfer->transfer_delete($hash_id);

        ob_clean();
        echo json_encode($res);
    }
}
