<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Beranda
 *
 * @author ian
 */
class Beranda extends MY_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();                
        model('m_alur_kas', 'alur_kas');
    }
    
    function index(){        
        //-- Index
        $data = array();
        $data['info_saldo_tabungan_list'] = $this->alur_kas->alur_kas_get_saldo_by_tabungan();        
        $data['total_kategori_list'] = $this->alur_kas->alur_kas_get_total_by_kategori_for_current_month();
        $data['total_per_day_for_current_month'] = $this->alur_kas->alur_kas_get_total_per_day_for_current_month();
        
        $data['tabungan_list'] = $this->alur_kas->tabungan_get_list();
        $data['kategori_list'] = $this->alur_kas->kategori_get_list();
        $data['total_transaction'] = $this->alur_kas->alur_kas_total_transaction_for_current_month();
        
        view('pages/beranda/index', $data);                
    }
}
