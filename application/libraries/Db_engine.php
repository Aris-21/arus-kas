<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db_engine
 *
 * @author ian
 */
class Db_engine {
    //put your code here
    
    protected $db;
    private $sql;
    private $bind_marker;

    public function __construct() {
        $ci =& get_instance();
        $this->db = $ci->db;
        $this->bind_marker = $this->db->bind_marker;
    }
    
    public function generate_datatables_input($filters = array(), $column_search = array(), $column_order = array(), $order = array(), $pagination = false){
      
      if(isset($filters["search"]["value"]) && !empty($filters["search"]["value"])){
        // remove null for global search
        $tmp = $column_search;
        $column_search = array();
        foreach ($tmp as $i => $v) {
          if($v == null || empty($v)) continue;
          $column_search[] = $v;
        }
        
        $i=0;        
        foreach ($column_search as $item) {          
          if($i == 0){
            $this->db->group_start();
            $this->db->like($item, $filters["search"]["value"]);
          } else{
            $this->db->or_like($item, $filters["search"]["value"]);
          }

          if(count($column_search) - 1 == $i){
            $this->db->group_end();
          }
          $i++;
        }                   
      }

      $i=0;
      foreach ($column_search as $index => $item) {          
        if(isset($filters['columns'][$index])){
          if(!empty($filters["columns"][$index]['search']['value'])){
            $value = $filters["columns"][$index]['search']['value'];   
            $this->db->like($item, trim($value));
          }
        }

        $i++;
      }

      if(isset($filters["order"])){          
        $this->db->order_by($column_order[$filters["order"][0]["column"]], $filters["order"][0]["dir"]);
      } else if(isset ($order)){
        $this->db->order_by(key($order), $order[key($order)]);
      }

      if($pagination){
        $start  = isset($filters["start"]) ? (int) $filters["start"] : 0;
        $length = isset($filters["length"]) ? (int) $filters["length"] : -1;
        
        if($length != -1) $this->db->limit($length, $start);        
      }
    }
    
    public function table_get_rows_count($table_name = ""){
      if(empty($table_name)) return 0;
      
      $this->db->select("count(1) as count");
      $this->db->from($table_name);
      $res = $this->db->get()->result_array();
      $res = $res[0];
      return $res["count"];
    }
    
    final protected function query($sql, $bind=false, $return_object = true){
        $this->sql = $sql;        
        if(is_array($bind) and count($bind)>0){
            $bind = $this->process_bind($bind);
        }
        $query = $this->db->query($this->sql, $bind, $return_object);
        return $query->result_array();
    }

    private function process_bind($bind){
        $bindOrder = null;
        $bindList = null;

        $pattern = "/[^']:[A-Za-z0-9_]+[^']/";
        $preg = preg_match_all($pattern, $this->sql, $matches, PREG_OFFSET_CAPTURE);
        if($preg !== 0 and $preg !== false){
            foreach($matches[0] as $key=>$val){
                $bindOrder[$key] = trim($val[0]);
            }
            foreach($bindOrder as $field){
                $this->sql = str_replace($field, $this->bind_marker, $this->sql);
                $bindList[] = $bind[$field];
            }
        }else{
            $bindList = $bind;
        }

        return $bindList;
    }
    
    function get_id_by_hash_id($hash_id = "", $table_name = ""){
        if(empty($hash_id)) return 0;        
        if(trim($hash_id) == "0") return 0;
        if(empty($table_name)) return 0;
        
        $this->db->select("id");
        $this->db->from($table_name);
        $this->db->where("md5(id)", $hash_id);
        $res = $this->db->get()->result_array();
        
        if(count($res) == 0) return 0;
        $res = $res[0];
        
        return (int)$res['id'];
    }
    
    function get_parent_id_by_parent_hash_id($parent_hash_id = "", $table_name){
        if(empty($parent_hash_id)) return 0;        
        if(trim($parent_hash_id) == "0") return 0;
        if(empty($table_name)) return 0;                
        
        $this->db->select("parent_id");
        $this->db->from($table_name);
        $this->db->where("md5(parent_id)", $parent_hash_id);                
        
        $res = $this->db->get()->result_array();
                
        
        if(count($res) == 0) return 0;
        $res = $res[0];
        
        return (int)$res['parent_id'];
    }

    function get_app_setting_list(){
        $this->db->select("*");
        $this->db->from("app_settings");
        $res = $this->db->get()->result_array();
        
        if(count($res) == 0) return $res;
        return $res[0];
    }
}
