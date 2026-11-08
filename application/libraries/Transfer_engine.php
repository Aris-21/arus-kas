<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transfer_engine
 *
 * @author ian
 */
class Transfer_engine extends Db_engine {
    //put your code here
        
    public function __construct() {
        parent::__construct();
    }
    
    function transfer_get_list($filters = array(), $pagination = false, $datatables = false){
        // jumlah index sesuai jumlah kolom di front-end
        $column_search  = array(
            null,     
            null,     
            "transfer.no_kas_number_formatted",
            "transfer.tanggal",
            "tabungan_sumber.nama",
            "tabungan_tujuan.nama",
            "transfer.jumlah",
            "transfer.keterangan",
            "modified", 
            "modifier_user_name", 
            null
        );
        $column_order   = $column_search;
        $order          = array("no_transfer_number_formatted" => "desc");

        $this->db->select("
            transfer.*, 
            tabungan_sumber.nama nama_tabungan_sumber,
            tabungan_tujuan.nama nama_tabungan_tujuan
        ");
        $this->db->from("transfer");
        $this->db->join("tabungan tabungan_sumber", "tabungan_sumber.id = transfer.tabungan_sumber_id", "left");
        $this->db->join("tabungan tabungan_tujuan", "tabungan_tujuan.id = transfer.tabungan_tujuan_id", "left");        
        
        foreach ($filters as $key => $value) {
            switch ($key) {
                case "id":
                    $this->db->where("transfer.id", (int)$value);
                    unset($filters[$key]);
                    break;
                case "tabungan_sumber_id":
                    $this->db->where("transfer.tabungan_sumber_id", (int)$value);
                    unset($filters[$key]);
                    break;
                case "tabungan_tujuan_id":
                    $this->db->where("transfer.tabungan_tujuan_id", (int)$value);
                    unset($filters[$key]);
                    break;
                case "hash_id":
                    $this->db->where("md5(transfer.id)", $value);
                    unset($filters[$key]);
                    break;
                case "no_referensi":
                    $this->db->like("transfer.no_referensi", trim($value));
                    unset($filters[$key]);
                    break;
                case "no_transfer":
                    $this->db->like("transfer.no_transfer", trim($value));
                    unset($filters[$key]);
                    break;
                case "tanggal":
                    $this->db->where("transfer.tanggal", trim($value));
                    unset($filters[$key]);
                    break;                
                case "date_start":
                    $this->db->where("transfer.tanggal >=", trim($value));
                    unset($filters[$key]);
                    break;                
                case "date_end":
                    $this->db->where("transfer.tanggal <=", trim($value));
                    unset($filters[$key]);
                    break;                

                default:
                    break;
            }
        }
        
        if($datatables){
            $this->generate_datatables_input($filters,$column_search, $column_order,$order,$pagination);
        }
        
        $res = $this->db->get()->result_array();
        return $res;
    }
    
    function transfer_get($id = 0){
        if($id == 0) return array();
        
        $filters = array();
        $filters['id'] = (int)$id;
        $res = $this->transfer_get_list($filters);
        
        if(count($res) == 0) return array();
        return $res[0];
    }
    
    function transfer_save($data = array()){
        if(!is_array($data)) return 0;
        if(count($data) == 0) return 0;
        
        $id = (int)$data['id'];
        $created = date("Y-m-d H:i:s", strtotime($data["created"]));
        $creator_user_id = (int)$data['creator_user_id'];        
        $creator_user_name = trim($data["creator_user_name"]);
        $modified = date("Y-m-d H:i:s", strtotime($data["modified"]));
        $modifier_user_id = (int)$data['modifier_user_id'];        
        $modifier_user_name = trim($data["modifier_user_name"]);

        $no_transfer_number = trim($data['no_transfer_number']);
        $no_transfer_number_formatted = trim($data['no_transfer_number_formatted']);

        $this->db->set("id", $id);
        $this->db->set("created", $created);
        $this->db->set("creator_user_id", $creator_user_id);
        $this->db->set("creator_user_name", $creator_user_name);
        $this->db->set("modified", $modified);
        $this->db->set("modifier_user_id", $modifier_user_id);
        $this->db->set("modifier_user_name", $modifier_user_name);
        $this->db->set("no_transfer_number", $no_transfer_number);
        $this->db->set("no_transfer_number_formatted", $no_transfer_number_formatted);
        $this->db->set("no_referensi", trim($data['no_referensi']));
        $this->db->set("tanggal", date('Y-m-d', strtotime($data['tanggal'])));
        $this->db->set("jumlah", (double)$data['jumlah']);
        $this->db->set("keterangan", addslashes(trim($data['keterangan'])));
        $this->db->set("tabungan_sumber_id", (int)$data['tabungan_sumber_id']);
        $this->db->set("tabungan_tujuan_id", (int)$data['tabungan_tujuan_id']);
        $this->db->replace("transfer");

        if($id == 0){            
            $id = $this->db->insert_id();
            
            $no_transfer_number = $this->transfer_get_next_no_transfer_number();
            $no_transfer_number_formatted = $this->transfer_generate_no_transfer_number_formatted($no_transfer_number, "TF/" . date('Y/m') . "/");
            
            $this->db->set("no_transfer_number", $no_transfer_number);
            $this->db->set("no_transfer_number_formatted", $no_transfer_number_formatted);
            $this->db->where("id", $id);
            $this->db->update("transfer");                        
        }
        return $id;
    }
    
    function transfer_delete($id = 0){
        if($id == 0) return 0;
        
        $this->db->where("id", $id);        
        $this->db->delete("transfer");                
        
        return $id;
    }
            
    function transfer_get_next_no_transfer_number() {

        $sql = "
                    select
                            max(no_transfer_number) + 1 next
                        from
                            transfer
                  ";
        
        $res = $this->query($sql);
        if(count($res) == 0) return 1;
        
        $next_no_transfer_number = (int)$res[0]["next"];
        if($next_no_transfer_number == 0) return 1;
        return $next_no_transfer_number;
    }
    
    function transfer_generate_no_transfer_number_formatted($no_transfer_number, $prefix) {

        $no_transfer_number_formatted = $prefix . str_pad($no_transfer_number, 6, 0, STR_PAD_LEFT);
        return $no_transfer_number_formatted;
    }
}
