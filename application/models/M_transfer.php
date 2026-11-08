<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_transfer
 *
 * @author ian
 */
class M_transfer extends MY_Model {
    //put your code here
    
    var $transfer_engine;    
    private $alur_kas_engine;
    private $tabungan_engine;

    var $user_id;
    var $user_name;
    public function __construct() {
        parent::__construct();
                
        $this->transfer_engine = new Transfer_engine();
        $this->alur_kas_engine = new Alur_kas_engine();
        $this->tabungan_engine = new Tabungan_engine();

        $user = get_session("user");
        $user_id    = isset($user["id"]) ? (int) $user["id"] : 0;
        $user_name  = isset($user["name"]) ? $user["name"] : "";

        $this->user_id = $user_id;
        $this->user_name = $user_name;
    }
    
    function transfer_get_list($filters = array()){
        $filters = array();
        $res = $this->transfer_engine->transfer_get_list($filters, true, true);

        $no = isset($filters["start"]) ? (int) $filters["start"] : 0;
        $final_res = array();
        foreach($res as $r){
            $modified = $r["modified"] == null ? "" : date("Y-m-d H:i:s", strtotime($r["modified"]));

            $no++;
            $row = array();
            $row["no"] = $no;

            $row["hash_id"] = md5($r["id"]);
            $row["no_transfer_number_formatted"] = $r["no_transfer_number_formatted"];
            $row["tanggal"] = date("d M Y", strtotime($r["tanggal"]));
            $row["tabungan_sumber_nama"] = $r["nama_tabungan_sumber"];
            $row["tabungan_tujuan_nama"] = $r["nama_tabungan_tujuan"];
            $row["jumlah"] = "Rp. " . number_format($r['jumlah']);
            $row["keterangan"] = $r["keterangan"];
            $row["modified"] = $modified;
            $row["modifier_user_name"] = $r["modifier_user_name"];

            $final_res[] = $row;
        }
        return $final_res;
    }

    function transfer_get_filtered_total($filters = array()){
        $filters = array();
        $res = $this->transfer_engine->transfer_get_list($filters, false, true);
        return count($res);
    }
    function transfer_get_total($filters = array()){
        $filters = array();
        $res = $this->transfer_engine->transfer_get_list($filters);
        return count($res);
    }
    
    function transfer_get($hash_id = ""){
        
        $filters = array();
        $filters["hash_id"] = $hash_id;
        $res = $this->transfer_engine->transfer_get_list($filters);
        if(count($res) == 0) return array();
        $res = $res[0];
        
        return $res;
    }
    
    function transfer_save($post = array()){
        if(!is_array($post)) return set_http_response_error(201, "Invalid input #1");
        if(count($post) == 0) return set_http_response_error(201, "Invalid input #2");
        
        $hash_id                    = post("hash_id");        
        $tabungan_sumber_hash_id    = post("tabungan_sumber_hash_id");
        $tabungan_tujuan_hash_id    = post("tabungan_tujuan_hash_id");
        $no_referensi               = post("no_referensi");
        $tanggal                    = post("tanggal");        
        $jumlah                     = post("jumlah");
        $keterangan                 = post("keterangan");
        
        $tanggal_list = explode("/", $tanggal);
        if(count($tanggal_list) == 3) {
            $tanggal = $tanggal_list[2] . "-" . $tanggal_list[0] . "-" . $tanggal_list[1];          
        }else{
            $tanggal = "";
        }
        if(empty($tanggal)) return set_http_response_error(201, "Invalid Tanggal");
        
        
        // **
        // check hash id dan get current data if hash_id is not empty
        $id = 0;
        $created = date("Y-m-d H:i:s");
        $creator_user_id = $this->user_id;
        $creator_user_name = $this->user_name;
        $current_tabungan_id = 0;
        $current_kategori_id = 0;
        $no_transfer_number = 0;
        $no_transfer_number_formatted = "";
        $current_tabungan_sumber_id = 0;
        $current_tabungan_tujuan_id = 0;
        if(!empty($hash_id)){
            $filters = array();
            $filters["hash_id"] = $hash_id;
            $res = $this->transfer_engine->transfer_get_list($filters);
            if(count($res) == 0){
                return set_http_response_error(201, "Invalid Pindah Buku (Transfer)");
            }
            $res = $res[0];
            $id = (int) $res["id"];
            $no_transfer_number = (int) $res["no_transfer_number"];
            $no_transfer_number_formatted = trim($res["no_transfer_number_formatted"]);
            $current_tabungan_sumber_id = (int) $res["tabungan_sumber_id"];
            $current_tabungan_tujuan_id = (int) $res["tabungan_tujuan_id"];            

            $created = date("Y-m-d H:i:s", strtotime($res['created']));
            $creator_user_id = (int) $res["creator_user_id"];
            $creator_user_name = trim($res["creator_user_name"]);
        }


        // **
        // check tabungan sumber hash id dan get tabungan sumber id
        $filters = array();
        $filters["hash_id"] = $tabungan_sumber_hash_id;
        $res = $this->tabungan_engine->tabungan_get_list($filters);
        if(count($res) == 0){
            return set_http_response_error(201, "Invalid Tabungan Sumber");
        }
        $res = $res[0];
        $tabungan_sumber_id = (int) $res["id"];
        
        // **
        // check tabungan tujuan hash id dan get tabungan tujuan id
        $filters = array();
        $filters["hash_id"] = $tabungan_tujuan_hash_id;
        $res = $this->tabungan_engine->tabungan_get_list($filters);
        if(count($res) == 0){
            return set_http_response_error(201, "Invalid Tabungan tujuan");
        }
        $res = $res[0];
        $tabungan_tujuan_id = (int) $res["id"];
        
        // cek saldo tabungan sumber
        $saldo = 0;
        $res = $this->alur_kas_engine->alur_kas_get_saldo_by_tabungan($tabungan_sumber_id);
        if(count($res) == 0) $saldo = 0;
        $res = $res[$tabungan_sumber_id];                            
        $saldo = (double)$res['saldo'];            
        if($saldo < $jumlah) {
            
            // **
            // jika edit, maka check jumlah sebelumnya yang ada pada database, 
            // jika jumlah yang dimasukkan saat ini lebih besar dari jumlah saat ini pada database, 
            // maka keadaan ini user ingin mengubah nilai transfer yang lebih besar
            if($id > 0){
                $filters = array();
                $filters["id"] = $id;
                $res = $this->transfer_engine->transfer_get_list($filters);
                if(count($res) > 0 ){
                    $res = $res[0];
                    $jumlah_saat_ini = (double) $res["jumlah"];

                    if($jumlah > $jumlah_saat_ini){
                        return set_http_response_error(201, "Saldo tidak mencukupi untuk Tabungan sumber. <br>Saldo untuk Tabungan sumber : Rp." . number_format($saldo, 0,",", "."));
                    }
                }
            }else{
                return set_http_response_error(201, "Saldo tidak mencukupi untuk Tabungan sumber. <br>Saldo untuk Tabungan sumber : Rp." . number_format($saldo, 0,",", "."));
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

            "no_transfer_number" => $no_transfer_number,
            "no_transfer_number_formatted" => $no_transfer_number_formatted,

            "no_referensi" => $no_referensi, 
            "tanggal" => $tanggal, 
            "jumlah" => $jumlah, 
            "keterangan" => $keterangan,
            "tabungan_sumber_id" => $tabungan_sumber_id, 
            "tabungan_tujuan_id" => $tabungan_tujuan_id
        );
        
        $this->db->trans_begin();
        try {
            // **
            // save transfer
            $res = $this->transfer_engine->transfer_save($data);
            if((int)$res == 0){
                throw new Exception("Transfer gagal disimpan #1");                
            }
            $transfer_id = $res;

            // **
            // ambil no transfer yang baru disimpan berdasarkan transfer_id
            $filters = array();
            $filters["id"] = $transfer_id;
            $res = $this->transfer_engine->transfer_get_list($filters);
            $res = $res[0];
            $no_transfer = $res['no_transfer_number_formatted'];
            
            // ** 
            // hapus transfer pada alur kas
            if($transfer_id != 0){
                $res = $this->alur_kas_engine->alur_kas_delete_for_transer($transfer_id);
                if((int)$res == 0){
                    throw new Exception("Transfer gagal disimpan #2");
                };
            }

            $alur_kas_data = array(
                "id" => 0, 
                "created" => $created, 
                "creator_user_id" => $creator_user_id, 
                "creator_user_name" => $creator_user_name, 
                "modified" => date("Y-m-d H:i:s"), 
                "modifier_user_id" => $this->user_id, 
                "modifier_user_name" => $this->user_name, 

                "no_kas_number" => "",
                "no_kas_number_formatted" => "",

                "no_referensi" => $no_transfer, 
                "tanggal" => $tanggal, 
                "kategori_id" => 0, 
                "keterangan" => $keterangan,
                "transfer_id" => $transfer_id,

                "jumlah_masuk" => 0, 
                "jumlah_keluar" => $jumlah, 
                "alur_kas" => "0",
                "tabungan_id" => $tabungan_sumber_id, 
            );

            // **
            // save ke alur kas sebagai kas keluar
            $res = $this->alur_kas_engine->alur_kas_save($alur_kas_data);
            if((int)$res == 0){
                throw new Exception("Transfer gagal disimpan #3");                
            }
            
            // ** ubah data alur kas keluar menjadi alur kas masuk
            $alur_kas_data["jumlah_masuk"] = $jumlah;
            $alur_kas_data["jumlah_keluar"] = 0;
            $alur_kas_data["alur_kas"] = "1";
            $alur_kas_data["tabungan_id"] = $tabungan_tujuan_id;

            // **
            // save ke alur kas sebagai kas masuk
            $res = $this->alur_kas_engine->alur_kas_save($alur_kas_data);
            if((int) $res == 0){
                throw new Exception("Transfer gagal disimpan #4");                
            }

        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Error: " . $e->getMessage());            
        }                                
        $this->db->trans_commit();
        return set_http_response_success("Pindah Buku (Transfer) telah disimpan");
    }
    
    function transfer_delete($hash_id = ""){
        $filters = array();
        $filters["hash_id"] = $hash_id;
        $res = $this->transfer_engine->transfer_get_list($filters);
        if(count($res) == 0){
            return set_http_response_error(201, "Invalid Pindah Buku (Transfer)");
        }
        $res = $res[0];
        $id = (int) $res["id"];

        $this->db->trans_begin();
        try {
            // **
            // delete transfer
            $res = $this->transfer_engine->transfer_delete($id);
            if((int) $res == 0){
                throw new Exception("Gagal menghapus transfer #1");
            }

            // **
            // delete alur kas berdasarkan transfer_id
            $res = $this->alur_kas_engine->alur_kas_delete_for_transer($id);
            if((int) $res == 0){
                throw new Exception("Gagal menghapus transfer #2");
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Error: " . $e->getMessage());            
        }                                
        $this->db->trans_commit();
        return set_http_response_success("Pindah Buku (Transfer) telah dihapus");
    }
    
    function tabungan_get_list(){
        $res = $this->tabungan_engine->tabungan_get_list();
        return $res;
    }
}
