<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_kategori
 *
 * @author ian
 */
class M_kategori extends MY_Model {
    //put your code here
        
    var $kategori_engine;
    var $alur_kas_engine;

    var $user_id;
    var $user_name;
    public function __construct() {
        parent::__construct();
                
        $this->kategori_engine = new Kategori_engine();
        $this->alur_kas_engine = new Alur_kas_engine();

        $user = get_session("user");
        $user_id    = isset($user["id"]) ? (int) $user["id"] : 0;
        $user_name  = isset($user["name"]) ? $user["name"] : "";

        $this->user_id = $user_id;
        $this->user_name = $user_name;
    }
    
    function kategori_get_list($filters = array()){
        $kategori_total_list = $this->alur_kas_engine->alur_kas_get_total_list_group_by_kategori_id();
                
        $res = $this->kategori_engine->kategori_get_list($filters, true, true);
        
        $no = isset($filters["start"]) ? (int) $filters["start"] : 0;
        $final_res = array();
        foreach($res as $index => $r){
            $kategori_id = (int)$r['id'];
            $alur_kas = $r['alur_kas'];
            
            $modified = $r["modified"] == null ? "" : date("Y-m-d H:i:s", strtotime($r["modified"]));

            $no++;
            $row = array();
            $row["no"] = $no;
            $row["hash_id"] = md5($r["id"]);
            $row["nama"] = $r["nama"];
            $row["keterangan"] = $r["keterangan"];
            $row["alur_kas"] = $r["alur_kas"];
            $row["modified"] = $modified;
            $row["modifier_user_name"] = $r["modifier_user_name"];
            
            $total = 0;
            if(isset($kategori_total_list[$kategori_id])){
                
                if($alur_kas == "MASUK") $total = $kategori_total_list[$kategori_id]['total_masuk'];
                if($alur_kas == "KELUAR") $total = $kategori_total_list[$kategori_id]['total_keluar'];                                
            }            
            $row["total_formatted"] = "Rp. " . number_format($total);
            
            $final_res[] = $row;
        }
        return $final_res;
    }

    function kategori_get_filtered_total($filters = array()){
        $res = $this->kategori_engine->kategori_get_list($filters, false, true);
        return count($res);
    }

    function kategori_get_total($filters = array()){
        $res = $this->kategori_engine->kategori_get_list($filters);
        return count($res);
    }
    
    function kategori_get($hash_id = ""){                
        $filters = array();
        $filters["hash_id"] = $hash_id;        
        $res = $this->kategori_engine->kategori_get_list($filters);
        if(count($res) == 0) return array();
        $res = $res[0];
        return $res;
    }
    
    function kategori_save(){
        $hash_id = trim($this->input->post('hash_id'));
        $nama = trim($this->input->post('nama'));
        $keterangan = trim($this->input->post('keterangan'));
        $alur_kas = trim($this->input->post('alur_kas'));
        
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
            $res = $this->kategori_engine->kategori_get_list($filters);
            if(count($res) == 0) return set_http_response_error(201, "Invalid Kategori");
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
        $res = $this->kategori_engine->kategori_get_list($filters);
        if(count($res) > 0){
            $res = $res[0];
            $cur_id = (int)$res['id'];
                        
            if($id != $cur_id)  return set_http_response_error(201, "Kategori $nama sudah ada");
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
            "keterangan" => $keterangan, 
            "alur_kas" => $alur_kas
        );

        $this->db->trans_begin();
        try {
            $res = $this->kategori_engine->kategori_save($data);
            if((int) $res == 0) {
                throw new Exception("Gagal menyimpan kategori");                
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Error: " . $e->getMessage());
        }

        $this->db->trans_commit();
        return set_http_response_success("Sukses menyimpan kategori");
    }
    
    function kategori_delete($hash_id = ""){
        $filters = array();
        $filters["hash_id"] = $hash_id;
        $res = $this->kategori_engine->kategori_get_list($filters);
        if(count($res) == 0) return set_http_response_error(201, "Invalid Kategori");
        $res = $res[0];
        $id = (int) $res["id"];
                
        $filters = array(
            "kategori_id" => $id
        );
        $res = $this->alur_kas_engine->alur_kas_get_list($filters);
        if(count($res) > 0) return set_http_response_error (201, "Kategori ini sedang terhubung pada Alur Kas");
        
        $this->db->trans_begin();
        try {
            $res = $this->kategori_engine->kategori_delete($id);
            if($res == 0){
                throw new Exception("Gagal menghapus kategori");                
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return set_http_response_error(201, "Error: " . $e->getMessage());
        }

        $this->db->trans_commit();
        return set_http_response_success("Sukses menghapus kategori");
    }
}
