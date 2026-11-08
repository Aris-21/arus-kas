<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_alur_kas
 *
 * @author ian
 */
class M_alur_kas extends MY_Model {
    //put your code here
    
    var $alur_kas_engine;
    var $tabungan_engine;
    var $kategori_engine;

    var $user_id;
    var $user_name;
    public function __construct() {
        parent::__construct();        
        $this->alur_kas_engine = new Alur_kas_engine();
        $this->tabungan_engine = new Tabungan_engine();
        $this->kategori_engine = new Kategori_engine();

        $user = get_session("user");
        $user_id    = isset($user["id"]) ? (int) $user["id"] : 0;
        $user_name  = isset($user["name"]) ? $user["name"] : "";

        $this->user_id = $user_id;
        $this->user_name = $user_name;
    }
            
    function alur_kas_get_list($filters = array()){
        $res = $this->alur_kas_engine->alur_kas_get_list($filters, true, true);

        $no = isset($filters["start"]) ? (int) $filters["start"] : 0;
        $final_res = array();

        foreach($res as $r){
            $modified = $r["modified"] == null ? "" : date("Y-m-d H:i:s", strtotime($r["modified"]));

            $no++;
            $row = array();
            $row["no"] = $no;

            $row["hash_id"] = md5($r["id"]);
            $row["no_kas_number_formatted"] = $r["no_kas_number_formatted"];
            $row["tanggal"] = date("d M Y", strtotime($r["tanggal"]));
            $row["kategori_nama"] = $r["nama_kategori"];
            $row["tabungan_nama"] = $r["nama_tabungan"];
            $row["jumlah_masuk"] = "Rp. " . number_format($r['jumlah_masuk']);
            $row["jumlah_keluar"] = "Rp. " . number_format($r['jumlah_keluar']);
            $row["keterangan"] = $r["keterangan"];
            $row["modified"] = $modified;
            $row["modifier_user_name"] = $r["modifier_user_name"];
            $row["allow_edit"] = 1;

            if((int) $r["transfer_id"] != 0) {
                $row["allow_edit"] = 0;
                $row["kategori_nama"] = "<i>Pindah Buku</i>";
            }            

            $final_res[] = $row;
        }
        return $final_res;
    }

    function alur_kas_get_filtered_total($filters = array()){
        $res = $this->alur_kas_engine->alur_kas_get_list($filters, false, true);
        return count($res);
    }

    function alur_kas_get_total($filters = array()){
        $res = $this->alur_kas_engine->alur_kas_get_list($filters);
        return count($res);
    }
    
    function alur_kas_get($hash_id = ""){
        $filters = array();
        $filters["hash_id"] = $hash_id;
        $res = $this->alur_kas_engine->alur_kas_get_list($filters);
        if(count($res) == 0) return array();
        $res = $res[0];

        return $res;
    }
    
    function alur_kas_get_saldo(){
        $res = $this->alur_kas_engine->alur_kas_get_saldo();        
        return $res;
    }
    
    function alur_kas_save($post = array()){        
        
        if(!is_array($post)) return set_http_response_error(201, "Invalid Input #1");
        if(count($post) == 0) return set_http_response_error(201, "Invalid Input #2");                      
        
        $hash_id = trim($this->input->post('hash_id'));
        $no_referensi = $this->input->post('no_referensi');
        $tanggal = $this->input->post('tanggal');
        $jumlah = (double)$this->input->post('jumlah');        
        $alur_kas_input = trim($this->input->post('alur_kas'));                
        $keterangan = trim($this->input->post('keterangan'));
        $tabungan_hash_id = $this->input->post('tabungan_hash_id');
        $kategori_hash_id = $this->input->post('kategori_hash_id');
        
        $tanggal_list = explode("/", $tanggal);
        if(count($tanggal_list) == 3) {
            $tanggal = $tanggal_list[2] . "-" . $tanggal_list[0] . "-" . $tanggal_list[1];          
        }else{
            $tanggal = "";
        }
        if(empty($tanggal)) return set_http_response_error(201, "Invalid Tanggal");

        $jumlah_masuk = 0;
        $jumlah_keluar = 0;
        $alur_kas = "-1";
        if($alur_kas_input == "MASUK") {
            $alur_kas = "1";            
        }
        if($alur_kas_input == "KELUAR") {
            $alur_kas = "0";              
        }        
        if($jumlah == 0) return set_http_response_error(201, "Invalid Jumlah Input");
                        
        // **
        // check tabungan hash_id and get tabungan_id
        $filters = array();
        $filters["hash_id"] = $tabungan_hash_id;
        $res = $this->tabungan_engine->tabungan_get_list($filters);
        if(count($res) == 0){
            return set_http_response_error(201, "Invalid Tabungan");            
        }
        $res = $res[0];
        $tabungan_id = (int) $res["id"];
                        
        // **
        // check kategori hash_id and get kategori_id
        $filters = array();
        $filters["hash_id"] = $kategori_hash_id;
        $res = $this->kategori_engine->kategori_get_list($filters);
        if(count($res) == 0){
            return set_http_response_error(201, "Invalid kategori");            
        }
        $res = $res[0];
        $kategori_id = (int) $res["id"];
        
        // **
        // check hash_id and get alur_kas_id, current_tabungan_id, current_kategori_id
        $id = 0;
        $created = date("Y-m-d H:i:s");
        $creator_user_id = $this->user_id;
        $creator_user_name = $this->user_name;
        $current_tabungan_id = 0;
        $current_kategori_id = 0;
        $transfer_id = 0;
        $no_kas_number = 0;
        $no_kas_number_formatted = "";
        $current_alur_kas = "";
        if(!empty($hash_id)){
            $filters = array();
            $filters["hash_id"] = $hash_id;
            $res = $this->alur_kas_engine->alur_kas_get_list($filters);
            if(count($res) == 0){
                return set_http_response_error(201, "Invalid Alur Kas");                
            }
            $res = $res[0];
            $id = (int) $res["id"];
            $no_kas_number = (int) $res["no_kas_number"];
            $no_kas_number_formatted = trim($res["no_kas_number_formatted"]);
            $current_tabungan_id = (int) $res["tabungan_id"];
            $current_kategori_id = (int) $res["kategori_id"];
            $transfer_id = (int) $res["transfer_id"];

            $created = date("Y-m-d H:i:s", strtotime($res['created']));
            $creator_user_id = (int) $res["creator_user_id"];
            $creator_user_name = trim($res["creator_user_name"]);

            $alur_kas = (int) $res["alur_kas"];
        }

        if($id == 0 && $alur_kas == "-1") {
            return set_http_response_error(201, "Invalid Alur Kas");
        }

        if((int) $alur_kas == 1){
            $jumlah_masuk = $jumlah;
        }else{
            $jumlah_keluar = $jumlah;
        }

        // **
        // jika edit transfer, maka tolak
        if($transfer_id != 0){
            return set_http_response_error(201, "Alur Kas ini dibuat melalui modul Transfer dan hanya bisa diubah pada menu Transfer");
        }
        
        // cek saldo jika alur kas = keluar
        if($alur_kas == "0"){                        
            $saldo = 0;
            $res = $this->alur_kas_engine->alur_kas_get_saldo_by_tabungan($tabungan_id);
            if(count($res) == 0) $saldo = 0;
            
            $res = $res[$tabungan_id];                            
            $saldo = (double)$res['saldo'];            
            if($saldo < $jumlah_keluar){                
                if($current_tabungan_id != $tabungan_id){
                    return set_http_response_error(201, "Saldo tidak mencukupi untuk Tabungan yang dipilih. <br>Saldo untuk Tabungan yang dipilih: Rp." . number_format($saldo, 0,",", "."));                    
                }
            }
        }        
                
        
        $data = array(
            "id" => $id, 
            "created" => $created, 
            "creator_user_id" => $creator_user_id, 
            "creator_user_name" => $creator_user_name, 
            "modified" => date("Y-m-d H:i:s"), 
            "modifier_user_id" => $this->user_id, 
            "modifier_user_name" => $this->user_name, 

            "no_kas_number" => $no_kas_number,
            "no_kas_number_formatted" => $no_kas_number_formatted,

            "no_referensi" => $no_referensi, 
            "tanggal" => $tanggal, 
            "jumlah_masuk" => $jumlah_masuk, 
            "jumlah_keluar" => $jumlah_keluar, 
            "alur_kas" => $alur_kas,
            "keterangan" => $keterangan,
            "tabungan_id" => $tabungan_id, 
            "kategori_id" => $kategori_id
        );        
        $this->db->trans_begin();
        try {
            $res = (int)$this->alur_kas_engine->alur_kas_save($data);
            if($res == 0){
                throw new Exception("Gagal menyimpan alur kas");                
            }
            $id = $res;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Error: " . $e->getMessage());
        }        

        $this->db->trans_commit();
        return set_http_response_success("Alur kas telah disimpan $jumlah_masuk", array(), md5($id));
        
    }
    
    function alur_kas_delete($hash_id = ""){

        // **
        // check hash id and get id
        $filters = array();
        $filters["hash_id"] = $hash_id;
        $res = $this->alur_kas_engine->alur_kas_get_list($filters);
        if(count($res) == 0) {
            return set_http_response_error(201, "Invalid Alur Kas");
        }
        $res = $res[0];
        $id = (int) $res["id"];
        
        $this->db->trans_begin();
        try {
            $res = $this->alur_kas_engine->alur_kas_delete($id);
            if((int) $res == 0){
                throw new Exception("Gagal menghapus alur kas");                
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Error: " . $e->getMessage());
        }

        $this->db->trans_commit();
        return set_http_response_success("Alur kas telah dihapus");
    }
    
    function alur_kas_get_saldo_by_tabungan($tabungan_id = 0){
        $res = $this->alur_kas_engine->alur_kas_get_saldo_by_tabungan($tabungan_id);
        return $res;
    }
    
    function alur_kas_get_saldo_by_kategori($kategori_id = 0){
        $res = $this->alur_kas_engine->alur_kas_get_saldo_by_kategori($kategori_id);
        return $res;
    }    
    
    function alur_kas_get_total_by_kategori(){
        $res = $this->alur_kas_engine->alur_kas_get_total_list_group_by_kategori_id();
        return $res;
    }
    
    function alur_kas_get_total_by_kategori_for_current_month(){
        $res = $this->alur_kas_engine->alur_kas_get_total_list_for_current_month_group_by_kategori_id();
        return $res;
    }
    
    function alur_kas_get_total_per_day_for_current_month(){
        $res = $this->alur_kas_engine->alur_kas_get_total_per_day_for_current_month();
        return $res;
    }

    function alur_kas_get_dashboard_info(){

        // **
        // get total pemasukkan dan pengeluaran bulan ini
        $total_per_day_for_current_month_list = $this->alur_kas_engine->alur_kas_get_total_per_day_for_current_month();
        $total_pemasukkan = 0;
        $total_pengeluaran = 0;

        foreach ($total_per_day_for_current_month_list as $day => $l) {
            if(isset($l['total_masuk'])){
                $total_pemasukkan += (double)$l['total_masuk'];                            
            }
            if(isset($l['total_keluar'])){
                $total_pengeluaran += (double)$l['total_keluar'];
            }
        }

        // **
        // get total saldo
        $saldo_tabungan_list = $this->alur_kas_engine->alur_kas_get_saldo_by_tabungan();
        $total_saldo = 0;
        foreach ($saldo_tabungan_list as $l) {
            $total_saldo += (double) $l["saldo"];
        }
        
        $result = array();
        $result["total_saldo"] = "Rp. " . number_format($total_saldo, 0, ",", ".");
        $result["total_pemasukkan"] = "Rp. " . number_format($total_pemasukkan, 0, ",", ".");
        $result["total_pengeluaran"] = "Rp. " . number_format($total_pengeluaran, 0, ",", ".");

        return set_http_response_success("Success", $result);
    }
    
    function alur_kas_total_transaction_for_current_month(){
        $filters = array();
        $filters['tanggal_mulai'] = date('Y-m-01 00:00:00');
        $filters['tanggal_selesai'] = date('Y-m-t 23:59:59');
        
        $res = $this->alur_kas_engine->alur_kas_get_list($filters);                
        return count($res);
    }
  
    function alur_kas_get_saldo_sebelumnya($get = array()){
        $end_date = $this->input->get("start_date");

        $end_date_list = explode("/", $end_date);
        if(count($end_date_list) == 3) {
            $end_date = $end_date_list[2] . "-" . $end_date_list[0] . "-" . $end_date_list[1];          
        }else{
            $end_date = "";
        }        

        $end_date = date("Y-m-d", strtotime($end_date) - (60 * 60 *24));
        $res = $this->alur_kas_engine->kas_alur_get_saldo_sebelumnya_for_date($end_date);
        return $res;
    }
            
    function alur_kas_get_list_for_print($filters = array()){ 
        $start_date =  $this->input->get("start_date");
        $end_date =  $this->input->get("end_date");

        $start_date_list = explode("/", $start_date);
        if(count($start_date_list) == 3) {
            $start_date = $start_date_list[2] . "-" . $start_date_list[0] . "-" . $start_date_list[1];          
        }else{
            $start_date = "";
        }    
        $end_date_list = explode("/", $end_date);
        if(count($end_date_list) == 3) {
            $end_date = $end_date_list[2] . "-" . $end_date_list[0] . "-" . $end_date_list[1];          
        }else{
            $end_date = "";
        }    

        $filters["tanggal_mulai"] = $start_date;
        $filters["tanggal_selesai"] = $end_date;
        
        $res = $this->alur_kas_engine->alur_kas_get_list_for_print($filters);        
        return $res;
    }
    
    function tabungan_get_list(){
        $res = $this->tabungan_engine->tabungan_get_list();
        return $res;
    }
    
    function kategori_get_list(){        
        $res = $this->kategori_engine->kategori_get_list();
        return $res;
    }
}
