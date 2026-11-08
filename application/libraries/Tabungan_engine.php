<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tabungan_engina
 *
 * @author ian
 */
//require APPPATH . "libraries/Db_engine.php";
class Tabungan_engine extends Db_engine {
    //put your code here
        
    public function __construct() {
        parent::__construct();        
    }
    
    function tabungan_get_list($filters = array(), $pagination = false, $datatables = false){

        // jumlah index sesuai jumlah kolom di front-end
        $column_search  = array(
            null,     
            null,     
            "nama",
            "keterangan",
            "modified", 
            "modifier_user_name", 
            null            
        );
        $column_order   = $column_search;
        $order          = array("nama" => "asc");

        $this->db->select("*");
        $this->db->from("tabungan");        
        
        foreach ($filters as $key => $value) {
            switch ($key) {
                case "id":
                    $this->db->where("id", (int)$value);
                    unset($filters[$key]);
                    break;
                case "hash_id":
                    $this->db->where("md5(id)", $value);
                    unset($filters[$key]);
                    break;
                case "nama_like": 
                    $this->db->like("nama", trim($value));
                    unset($filters[$key]);
                    break;
                case "nama_match": 
                    $this->db->where("nama", trim($value));
                    unset($filters[$key]);
                    break;
                default:
                    break;
            }
        }

        if($datatables){
            $this->generate_datatables_input($filters,$column_search,$column_order,$order,$pagination);
        }
        
        $res = $this->db->get()->result_array();
        return $res;
    }
    
    function tabungan_get($id = 0){
        if($id == 0) return array();
        
        $filters = array(
            "id" => (int)$id
        );
        $res = $this->tabungan_get_list($filters);
        
        if(count($res) == 0) return array();
        return $res[0];
    }
    
    function tabungan_delete($id = 0){
        if($id == 0) return 0;
        
        $this->db->where("id", (int)$id);        
        $this->db->delete("tabungan");
        
        return $id;
    }
    
    function tabungan_save($data = array()){
        if(!is_array($data)) return 0;
        if(count($data) == 0) return 0;
        
        $id = (int)$data['id'];
        $created = $data["created"];
        $creator_user_id = (int) $data["creator_user_id"];
        $creator_user_name = trim($data["creator_user_name"]);
        $nama = trim($data['nama']);
        $keterangan = trim($data['keterangan']);
        $modified = $data["modified"];
        $modifier_user_id = (int) $data["modifier_user_id"];
        $modifier_user_name = trim($data["modifier_user_name"]);   
        
        $this->db->set("id", $id);
        $this->db->set("created", $created);
        $this->db->set("creator_user_id", $creator_user_id);
        $this->db->set("creator_user_name", $creator_user_name);
        $this->db->set("nama", $nama);
        $this->db->set("keterangan", $keterangan);
        $this->db->set("modified", $modified);
        $this->db->set("modifier_user_id", $modifier_user_id);
        $this->db->set("modifier_user_name", $modifier_user_name);        
        $this->db->replace("tabungan");

        if((int) $id == 0) $id = $this->db->insert_id();
        return $id;  
    }
}
