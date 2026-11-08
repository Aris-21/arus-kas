<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_tabungan
 *
 * @author ian
 */
class M_tabungan extends MY_Model {
    //put your code here
        
    var $tabungan_engine;
    var $alur_kas_engine;
    var $transfer_engine;

    var $user_id;
    var $user_name;
    public function __construct() {
        parent::__construct();
                
        $this->tabungan_engine = new Tabungan_engine();
        $this->alur_kas_engine = new Alur_kas_engine();
        $this->transfer_engine = new Transfer_engine();

        $user = get_session("user");
        $user_id    = isset($user["id"]) ? (int) $user["id"] : 0;
        $user_name  = isset($user["name"]) ? $user["name"] : "";

        $this->user_id = $user_id;
        $this->user_name = $user_name;
    }
    
    function tabungan_get_list($filters = array()){                        
        $res = $this->tabungan_engine->tabungan_get_list($filters, true, true);

        $saldo_tabungan_list = $this->alur_kas_engine->alur_kas_get_saldo_by_tabungan();

        $no = isset($filters["start"]) ? (int) $filters["start"] : 0;
        $final_res = array();
        foreach ($res as $index => $r) {            
            $modified = $r["modified"] == null ? "" : date("Y-m-d H:i:s", strtotime($r["modified"]));

            $no++;
            $row = array();
            $row["no"] = $no;
            $row["hash_id"] = md5($r["id"]);
            $row["nama"] = $r["nama"];
            $row["keterangan"] = $r["keterangan"];            
            $row["modified"] = $modified;
            $row["modifier_user_name"] = $r["modifier_user_name"];

            $saldo = 0;
            foreach ($saldo_tabungan_list as $tabungan_id => $l) {
                if((int)$r['id'] == $tabungan_id){
                    $saldo = (double)$l['saldo'];
                }
            }
            
            $row["saldo_formatted"] = "Rp. " . number_format($saldo);            
            $final_res[] = $row;
        }
        
        return $final_res;
    }
    
    function tabungan_get_filtered_total($filters = array()){
        $res = $this->tabungan_engine->tabungan_get_list($filters, false, true);
        return count($res);
    }

    function tabungan_get_total($filters = array()){
        $res = $this->tabungan_engine->tabungan_get_list($filters);
        return count($res);
    }
    
    function tabungan_get($hash_id = ""){                
        $filters = array();
        $filters["hash_id"] = $hash_id;        
        $res = $this->tabungan_engine->tabungan_get_list($filters);
        if(count($res) == 0) return array();
        $res = $res[0];
        return $res;
    }
    
    function tabungan_save(){
        $hash_id = trim($this->input->post('hash_id'));
        $nama = trim($this->input->post('nama'));
        $keterangan = trim($this->input->post('keterangan'));
        
        $id = 0;
        $created = date("Y-m-d H:i:s");
        $creator_user_id = $this->user_id;
        $creator_user_name = $this->user_name;
        // **
        // jika hash_id kosong, maka new data
        // jika hash_id tidak kosong maka edit data
        // jika hash_id tidak kosong, check hash_id 
        // jika hash_id valid, ambil current data
        if(!empty($hash_id)){
            $filters = array();
            $filters["hash_id"] = $hash_id;
            $res = $this->tabungan_engine->tabungan_get_list($filters);
            if(count($res) == 0) return set_http_response_error(201, "Invalid tabungan");
            $res = $res[0];
            $id = (int) $res["id"];
            $created = $res["created"];
            $creator_user_id = (int) $res["creator_user_id"];
            $creator_user_name = trim($res["creator_user_name"]);
        }
        
        // cek nama
        $filters = array(
            "nama_match" => $nama
        );
        $res = $this->tabungan_engine->tabungan_get_list($filters);
        if(count($res) > 0){
            $res = $res[0];
            $cur_id = (int)$res['id'];
                        
            if($id != $cur_id)  return set_http_response_error(201, "tabungan $nama sudah ada");
        }
        
        $data = array(
            "id" => $id, 
            "created" => $created, 
            "creator_user_id" => $creator_user_id, 
            "creator_user_name" => $creator_user_name, 
            "modified" => date("Y-m-d H:i:s"), 
            "modifier_user_id" => $this->user_id, 
            "modifier_user_name" => $this->user_name, 
            "nama" => $nama, 
            "keterangan" => $keterangan
        );

        $this->db->trans_begin();
        try {
            $res = $this->tabungan_engine->tabungan_save($data);
            if((int) $res == 0) {
                throw new Exception("Gagal menyimpan tabungan");                
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Error: " . $e->getMessage());
        }

        $this->db->trans_commit();
        return set_http_response_success("Sukses menyimpan tabungan");
    }
    
    function tabungan_delete($hash_id = ""){
        $filters = array();
        $filters["hash_id"] = $hash_id;
        $res = $this->tabungan_engine->tabungan_get_list($filters);
        if(count($res) == 0) return set_http_response_error(201, "Invalid tabungan");
        $res = $res[0];
        $id = (int) $res["id"];
        
        // **
        // check jika tabungan di gunakan pada alur kas
        $filters = array(
            "tabungan_id" => $id
        );
        $res = $this->alur_kas_engine->alur_kas_get_list($filters);
        if(count($res) > 0) return set_http_response_error (201, "tabungan ini sedang terhubung pada Alur Kas");
        
        // **
        // check jika tabungan di gunakan pada transfer sebagai tabungan sumber
        $filters = array();
        $filters["tabungan_sumber_id"] = $id;
        $res = $this->transfer_engine->transfer_get_list($filters);
        if(count($res) > 0){
            return set_http_response_error(201, "Tabungan ini sedang terhubung sebagai tabungan sumber pada modul Pindah Buku (Transfer)");
        }
        
        // **
        // check jika tabungan di gunakan pada transfer sebagai tabungan tujuan
        $filters = array();
        $filters["tabungan_tujuan_id"] = $id;
        $res = $this->transfer_engine->transfer_get_list($filters);
        if(count($res) > 0){
            return set_http_response_error(201, "Tabungan ini sedang terhubung sebagai tabungan tujuan pada modul Pindah Buku (Transfer)");
        }


        $this->db->trans_begin();
        try {
            $res = $this->tabungan_engine->tabungan_delete($id);
            if($res == 0){
                throw new Exception("Gagal menghapus tabungan");                
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Error: " . $e->getMessage());
        }

        $this->db->trans_commit();
        return set_http_response_success("Sukses menghapus tabungan");
    }
}
