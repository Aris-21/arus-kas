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
class Alur_kas_engine extends Db_engine {
    //put your code here
        
    public function __construct() {
        parent::__construct();
    }
    
function alur_kas_get_list($filters = array(), $pagination = false, $datatables = false)
{
    /*
     * ============================================================
     * DAFTAR KOLOM DATATABLE
     * ============================================================
     *
     * Urutan HARUS sama dengan kolom pada halaman Alur Kas:
     *
     * 0  = Nomor
     * 1  = Aksi
     * 2  = No Kas
     * 3  = Tanggal
     * 4  = Kategori
     * 5  = Tabungan
     * 6  = Jumlah Masuk
     * 7  = Jumlah Keluar
     * 8  = Keterangan
     * 9  = Terakhir Diubah
     * 10 = Diubah Oleh
     *
     */

    $column_search = array(
        null,
        null,
        "alur_kas.no_kas_number_formatted",
        "alur_kas.tanggal",
        "kategori.nama",
        "tabungan.nama",
        "alur_kas.jumlah_masuk",
        "alur_kas.jumlah_keluar",
        "alur_kas.keterangan",
        "alur_kas.modified",
        "alur_kas.modifier_user_name"
    );


    /*
     * Kolom yang dapat digunakan untuk ORDER BY.
     */

    $column_order = array(
        null,
        null,
        "alur_kas.no_kas_number",
        "alur_kas.tanggal",
        "kategori.nama",
        "tabungan.nama",
        "alur_kas.jumlah_masuk",
        "alur_kas.jumlah_keluar",
        "alur_kas.keterangan",
        "alur_kas.modified",
        "alur_kas.modifier_user_name"
    );


    /*
     * ============================================================
     * DEFAULT ORDER
     * ============================================================
     *
     * Jangan menggunakan no_kas_number_formatted sebagai urutan
     * utama karena nilainya berupa string:
     *
     * AK/M/26/07/000025
     * AK/K/26/07/000026
     *
     * Gunakan nomor kas numerik.
     */

    $order = array(
        "alur_kas.no_kas_number" => "desc"
    );


    /*
     * ============================================================
     * SELECT
     * ============================================================
     */

    $this->db->select("
        alur_kas.*,
        tabungan.nama AS nama_tabungan,
        kategori.nama AS nama_kategori
    ");


    /*
     * ============================================================
     * FROM
     * ============================================================
     */

    $this->db->from("alur_kas");


    /*
     * ============================================================
     * JOIN
     * ============================================================
     *
     * Tetap gunakan LEFT JOIN.
     *
     * Dengan LEFT JOIN, transaksi tidak hilang hanya karena
     * kategori atau tabungan bermasalah/tidak ditemukan.
     */

    $this->db->join(
        "tabungan",
        "tabungan.id = alur_kas.tabungan_id",
        "left"
    );


    $this->db->join(
        "kategori",
        "kategori.id = alur_kas.kategori_id",
        "left"
    );


    /*
     * ============================================================
     * FILTER
     * ============================================================
     */

    foreach ($filters as $key => $value) {


        switch ($key) {


            /*
             * ----------------------------------------------------
             * ID
             * ----------------------------------------------------
             */

            case "id":

                if ($value !== "") {

                    $this->db->where(
                        "alur_kas.id",
                        (int)$value
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * HASH ID
             * ----------------------------------------------------
             */

            case "hash_id":

                if (trim($value) != "") {

                    $this->db->where(
                        "md5(alur_kas.id)",
                        trim($value)
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * NOMOR KAS
             * ----------------------------------------------------
             */

            case "no_kas_number_formatted":

                if (trim($value) != "") {

                    $this->db->where(
                        "alur_kas.no_kas_number_formatted",
                        trim($value)
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * NOMOR REFERENSI
             * ----------------------------------------------------
             */

            case "no_referensi":

                if (trim($value) != "") {

                    $this->db->where(
                        "alur_kas.no_referensi",
                        trim($value)
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * TANGGAL
             * ----------------------------------------------------
             */

            case "tanggal":

                if (trim($value) != "") {

                    $this->db->where(
                        "alur_kas.tanggal",
                        date(
                            "Y-m-d",
                            strtotime(trim($value))
                        )
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * TANGGAL MULAI
             * ----------------------------------------------------
             */

            case "tanggal_mulai":

                if (trim($value) != "") {

                    $this->db->where(
                        "alur_kas.tanggal >=",
                        date(
                            "Y-m-d",
                            strtotime(trim($value))
                        )
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * TANGGAL SELESAI
             * ----------------------------------------------------
             */

            case "tanggal_selesai":

                if (trim($value) != "") {

                    $this->db->where(
                        "alur_kas.tanggal <=",
                        date(
                            "Y-m-d",
                            strtotime(trim($value))
                        )
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ====================================================
             * ALUR KAS
             * ====================================================
             *
             * BAGIAN INI PENTING.
             *
             * MASUK  = 1
             * KELUAR = 0
             *
             * Jangan menggunakan:
             *
             * if($value)
             * if(!empty($value))
             *
             * karena nilai 0 adalah transaksi KELUAR yang valid.
             */

            case "alur_kas":

                $alur_value = trim(
                    (string)$value
                );


                /*
                 * Konversi teks ke kode database.
                 */

                if (
                    strtoupper($alur_value)
                    == "MASUK"
                ) {

                    $alur_value = "1";

                }


                if (
                    strtoupper($alur_value)
                    == "KELUAR"
                ) {

                    $alur_value = "0";

                }


                /*
                 * Hanya jalankan filter jika
                 * nilainya benar-benar 0 atau 1.
                 */

                if (
                    $alur_value === "0"
                    ||
                    $alur_value === "1"
                ) {

                    $this->db->where(
                        "alur_kas.alur_kas",
                        $alur_value
                    );

                }


                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * KETERANGAN
             * ----------------------------------------------------
             */

            case "keterangan":

                if (trim($value) != "") {

                    $this->db->like(
                        "alur_kas.keterangan",
                        trim($value)
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * TABUNGAN
             * ----------------------------------------------------
             */

            case "tabungan_id":

                if (
                    $value !== ""
                    &&
                    $value !== null
                ) {

                    $this->db->where(
                        "alur_kas.tabungan_id",
                        (int)$value
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * KATEGORI
             * ----------------------------------------------------
             */

            case "kategori_id":

                if (
                    $value !== ""
                    &&
                    $value !== null
                ) {

                    $this->db->where(
                        "alur_kas.kategori_id",
                        (int)$value
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * TRANSFER ID
             * ----------------------------------------------------
             */

            case "transfer_id":

                if (
                    $value !== ""
                    &&
                    $value !== null
                ) {

                    $this->db->where(
                        "alur_kas.transfer_id",
                        (int)$value
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * DATE START
             * ----------------------------------------------------
             */

            case "date_start":

                if (trim($value) != "") {

                    $this->db->where(
                        "alur_kas.tanggal >=",
                        date(
                            "Y-m-d",
                            strtotime(trim($value))
                        )
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * DATE END
             * ----------------------------------------------------
             */

            case "date_end":

                if (trim($value) != "") {

                    $this->db->where(
                        "alur_kas.tanggal <=",
                        date(
                            "Y-m-d",
                            strtotime(trim($value))
                        )
                    );

                }

                unset($filters[$key]);

                break;



            /*
             * ----------------------------------------------------
             * PARAMETER DATATABLE
             * ----------------------------------------------------
             *
             * Parameter seperti:
             *
             * draw
             * start
             * length
             * search
             * order
             * columns
             *
             * jangan dihapus.
             *
             * Parameter tersebut akan diproses oleh:
             *
             * generate_datatables_input()
             */

            default:

                break;

        }

    }



    /*
     * ============================================================
     * DATATABLE MODE
     * ============================================================
     */

    if ($datatables) {


        $this->generate_datatables_input(
            $filters,
            $column_search,
            $column_order,
            $order,
            $pagination
        );


    } else {


        /*
         * ========================================================
         * NON DATATABLE MODE
         * ========================================================
         *
         * Urutkan transaksi terbaru di atas.
         */


        $this->db->order_by(
            "alur_kas.tanggal",
            "DESC"
        );


        $this->db->order_by(
            "alur_kas.no_kas_number",
            "DESC"
        );


        $this->db->order_by(
            "alur_kas.id",
            "DESC"
        );

    }



    /*
     * ============================================================
     * EXECUTE QUERY
     * ============================================================
     */

    $query =
        $this->db->get();



    /*
     * ============================================================
     * QUERY ERROR PROTECTION
     * ============================================================
     */

    if (!$query) {

        return array();

    }



    /*
     * ============================================================
     * RETURN DATA
     * ============================================================
     */

    return $query->result_array();

}

    function kas_alur_get_saldo_sebelumnya_for_date($date = ""){    
        if(empty($date)) return 0;
        
        $this->db->select("(sum(jumlah_masuk) - sum(jumlah_keluar)) saldo");
        $this->db->from("alur_kas");
        $this->db->where("tanggal <=", $date);
        $res = $this->db->get()->result_array();
        
        $res = $res[0];
        $saldo = (double) $res["saldo"];
        
        return $saldo;
    }

    function alur_kas_get_list_for_print($filters = array()){
        $this->db->select("
            alur_kas.*,
            tabungan.nama nama_tabungan,             
            kategori.nama nama_kategori
        ");
        $this->db->join("tabungan", "tabungan.id = alur_kas.tabungan_id", "left");
        $this->db->join("kategori", "kategori.id = alur_kas.kategori_id", "left");
        $this->db->from("alur_kas");
        
        foreach ($filters as $key => $value) {
            switch ($key) {
                case "id":
                    $this->db->where("alur_kas.id", (int)$value);
                    break;
                case "no_kas_number_formatted": 
                    $this->db->where("alur_kas.no_kas_number_formatted", trim($value));
                    break;
                case "no_referensi": 
                    $this->db->where("alur_kas.no_referensi", trim($value));
                    break;
                case "tanggal": 
                    $this->db->where("alur_kas.tanggal", date('Y-m-d', strtotime(trim($value))));
                    break;
                case "tanggal_mulai": 
                    $this->db->where("alur_kas.tanggal >=", $value);
                    unset($filters[$key]);
                    break;
                case "tanggal_selesai": 
                    $this->db->where("alur_kas.tanggal <=", $value);
                    unset($filters[$key]);
                    break;
                case "alur_kas": 
                    if(trim($value) == "MASUK") $value = "1";
                    if(trim($value) == "KELUAR") $value = "0";
                    $this->db->where("alur_kas.alur_kas", trim($value));
                    break;
                case "keterangan":
                    $this->db->like("alur_kas.keterangan", trim($value));
                    break;
                case "tabungan_id":
                    $this->db->where("alur_kas.tabungan_id", (int)$value);
                    break;
                case "kategori_id":
                    $this->db->where("alur_kas.kategori_id", (int)$value);
                    break;
                case "transfer_id":
                    $this->db->where("alur_kas.transfer_id", (int)$value);
                    break;
                default:
                    break;
            }
        }
        $this->db->order_by("alur_kas.tanggal asc, alur_kas.no_kas_number asc, alur_kas.transfer_id");
        $res = $this->db->get()->result_array();
        return $res;
    }
    
    function alur_kas_get($id = 0){
        if($id == 0) return array();
        
        $filters = array();
        $filters['id'] = $id;
        $res = $this->alur_kas_get_list($filters);
        
        if(count($res) == 0) return array();
        return $res[0];
    }
    
    function alur_kas_get_saldo(){
        $sql = "
            select 
                SUM(alur_kas.jumlah_masuk) - SUM(alur_kas.jumlah_keluar) saldo
            from
                alur_kas
            left join
                tabungan on tabungan.id = alur_kas.tabungan_id
            where 1
            ";
        $res = $this->query($sql);  
        
        if(count($res) == 0) return 0;
        $res = $res[0];
        $saldo = (double)$res['saldo'];
        return $saldo;
    }
    
    function alur_kas_get_saldo_by_tabungan($tabungan_id = 0){
        $filter_string_list = array();
        $filter_values_list = array();
        
        $filters = array();
        if($tabungan_id != 0) $filters['tabungan_id'] = $tabungan_id;
        
        foreach($filters as $index => $filter) {
            $filter = str_replace("\"", "\\\"", $filter);
            $filter = addslashes($filter);
            switch($index) {
                case "tabungan_id" :
                    $filter_string_list[] = " tabungan_id = :tabungan_id";
                    $filter_values_list[":tabungan_id"] = $filter;
                    break;         
                case "kategori_id" :
                    $filter_string_list[] = " kategori_id = :kategori_id";
                    $filter_values_list[":kategori_id"] = $filter;
                    break;         
                default:
                    break;
            }
        }
        $where_string = "";
        if(count($filter_string_list) != 0) {
            $filter_string = implode(" AND ", $filter_string_list);
            $where_string = "AND " . $filter_string;
        }      
                        
        $sql = "
            select 
                SUM(alur_kas.jumlah_masuk) - SUM(alur_kas.jumlah_keluar) saldo,
                alur_kas.id alur_kas_id,
                tabungan.id tabungan_id,
                tabungan.nama nama_tabungan
            from
                alur_kas
            left join
                tabungan on tabungan.id = alur_kas.tabungan_id
            where 1
                $where_string
            group by alur_kas.tabungan_id
            ";
        $res = $this->query($sql, $filter_values_list);            
        
        $final_res = array();
        foreach ($res as $r) {
            
            $final_res[$r['tabungan_id']] = $r;
        }
        return $final_res;        
    }
    
    function alur_kas_get_saldo_by_kategori($kategori_id = 0){
        $filter_string_list = array();
        $filter_values_list = array();
        
        $filters = array();
        if($kategori_id != 0) $filters['kategori_id'] = $kategori_id;                
        
        foreach($filters as $index => $filter) {
            $filter = str_replace("\"", "\\\"", $filter);
            $filter = addslashes($filter);
            switch($index) {
                case "tabungan_id" :
                    $filter_string_list[] = " tabungan_id = :tabungan_id";
                    $filter_values_list[":tabungan_id"] = $filter;
                    break;         
                case "kategori_id" :
                    $filter_string_list[] = " kategori_id = :kategori_id";
                    $filter_values_list[":kategori_id"] = $filter;
                    break;         
                default:
                    break;
            }
        }
        $where_string = "";
        if(count($filter_string_list) != 0) {
            $filter_string = implode(" AND ", $filter_string_list);
            $where_string = "AND " . $filter_string;
        }      
                        
        $sql = "
            select * from (
                select 
                    SUM(alur_kas.jumlah_masuk) - SUM(alur_kas.jumlah_keluar) saldo,
                    kategori.id kategori_id,
                    kategori.nama nama_kategori,
                    kategori.alur_kas
                from
                    alur_kas
                left join
                    kategori on kategori.id = alur_kas.kategori_id
                where 1
                    $where_string            
                group by alur_kas.kategori_id
            ) alur_kas
            order by saldo
            ";
        $res = $this->query($sql, $filter_values_list);   
        
        $final_res = array();
        foreach ($res as $r) {
            
            $final_res[$r['kategori_id']] = $r;
        }
        return $final_res;        
    }
    
    function alur_kas_get_total_list_group_by_kategori_id(){
        $filter_string_list = array();
        $filter_values_list = array();
        
        $filters = array();
        // if($kategori_id != 0) $filters['kategori_id'] = $kategori_id;
        
        foreach($filters as $index => $filter) {
            $filter = str_replace("\"", "\\\"", $filter);
            $filter = addslashes($filter);
            switch($index) {
                case "tabungan_id" :
                    $filter_string_list[] = " tabungan_id = :tabungan_id";
                    $filter_values_list[":tabungan_id"] = $filter;
                    break;         
                case "kategori_id" :
                    $filter_string_list[] = " kategori_id = :kategori_id";
                    $filter_values_list[":kategori_id"] = $filter;
                    break;         
                default:
                    break;
            }
        }
        $where_string = "";
        if(count($filter_string_list) != 0) {
            $filter_string = implode(" AND ", $filter_string_list);
            $where_string = "AND " . $filter_string;
        }      
                        
        $sql = "
            select * from (
                select 
                    SUM(alur_kas.jumlah_masuk) total_masuk,
                    SUM(alur_kas.jumlah_keluar) total_keluar,
                    kategori_id,
                    kategori.nama nama_kategori,
                    kategori.alur_kas
                from
                    alur_kas
                left join
                    kategori on kategori.id = alur_kas.kategori_id
                where 1
                    $where_string

                    and alur_kas.transfer_id = 0
                group by alur_kas.kategori_id
            ) alur_kas
            order by total_masuk desc, total_keluar desc
            ";
        $res = $this->query($sql, $filter_values_list);   
        
        $final_res = array();
        foreach ($res as $r) {
            
            $final_res[$r['kategori_id']] = $r;
        }
        
        return $final_res;        
    }
    
    function alur_kas_get_total_list_for_current_month_group_by_kategori_id(){
        $filter_string_list = array();
        $filter_values_list = array();
        
        $start_date = date('Y-m-01 00:00:00');
        $end_date = date('Y-m-t 23:59:59');
        
        $filters = array();
        // if($kategori_id != 0) $filters['kategori_id'] = $kategori_id;
        
        $filter_string_list[] = " alur_kas.tanggal >= :start_date";
        $filter_values_list[":start_date"] = $start_date;
        $filter_string_list[] = " alur_kas.tanggal <= :end_date";
        $filter_values_list[":end_date"] = $end_date;
        
        foreach($filters as $index => $filter) {
            $filter = str_replace("\"", "\\\"", $filter);
            $filter = addslashes($filter);
            switch($index) {
                case "tabungan_id" :
                    $filter_string_list[] = " tabungan_id = :tabungan_id";
                    $filter_values_list[":tabungan_id"] = $filter;
                    break;         
                case "kategori_id" :
                    $filter_string_list[] = " kategori_id = :kategori_id";
                    $filter_values_list[":kategori_id"] = $filter;
                    break;           
                default:
                    break;
            }
        }
        $where_string = "";
        if(count($filter_string_list) != 0) {
            $filter_string = implode(" AND ", $filter_string_list);
            $where_string = "AND " . $filter_string;
        }      
                        
        $sql = "
            select * from (
                select 
                    SUM(alur_kas.jumlah_masuk) total_masuk,
                    SUM(alur_kas.jumlah_keluar) total_keluar,
                    kategori_id,
                    kategori.nama nama_kategori,
                    kategori.alur_kas
                from
                    alur_kas
                left join
                    kategori on kategori.id = alur_kas.kategori_id
                where 1
                    $where_string

                    and alur_kas.transfer_id = 0
                group by alur_kas.kategori_id
            ) alur_kas
            order by total_masuk desc, total_keluar desc
            ";
        $res = $this->query($sql, $filter_values_list);  
        
        $final_res = array();
        foreach ($res as $r) {
            
            $final_res[$r['kategori_id']] = $r;
        }
        
        return $final_res;        
    }
    
    function alur_kas_get_total_per_day_for_current_month(){
        $filter_string_list = array();
        $filter_values_list = array();
        
        $start_date = date('Y-m-01 00:00:00');
        $end_date = date('Y-m-t 23:59:59');
        
        $filters = array();
        // if($kategori_id != 0) $filters['kategori_id'] = $kategori_id;
        
        $filter_string_list[] = " alur_kas.tanggal >= :start_date";
        $filter_values_list[":start_date"] = $start_date;
        $filter_string_list[] = " alur_kas.tanggal <= :end_date";
        $filter_values_list[":end_date"] = $end_date;
        
        foreach($filters as $index => $filter) {
            $filter = str_replace("\"", "\\\"", $filter);
            $filter = addslashes($filter);
            switch($index) {
                case "tabungan_id" :
                    $filter_string_list[] = " tabungan_id = :tabungan_id";
                    $filter_values_list[":tabungan_id"] = $filter;
                    break;         
                case "kategori_id" :
                    $filter_string_list[] = " kategori_id = :kategori_id";
                    $filter_values_list[":kategori_id"] = $filter;
                    break;           
                default:
                    break;
            }
        }
        $where_string = "";
        if(count($filter_string_list) != 0) {
            $filter_string = implode(" AND ", $filter_string_list);
            $where_string = "AND " . $filter_string;
        }      
                        
        $sql = "            
                select 
                    SUM(alur_kas.jumlah_masuk) total_masuk,
                    SUM(alur_kas.jumlah_keluar) total_keluar,
                    alur_kas.tanggal,
                    kategori_id,
                    kategori.nama nama_kategori,
                    kategori.alur_kas
                from
                    alur_kas
                left join
                    kategori on kategori.id = alur_kas.kategori_id
                where 1
                    $where_string

                    and alur_kas.transfer_id = 0
                group by alur_kas.tanggal
            ";
        $res = $this->query($sql, $filter_values_list);  
        
        $final_res = array();
        $start_day = 1;
        $end_day = date('t');
        for($i=$start_day; $i <= $end_day; $i++){
            $final_res[$i] = array();
        }
        
        foreach ($res as $r) {            
            $final_res[(int) date('d', strtotime($r['tanggal']))] = $r;
        }
        
        return $final_res;        
    }
    
    function alur_kas_delete($id = 0){
        if($id == 0) return 0;
        
        $this->db->where("id", (int)$id);        
        $this->db->delete("alur_kas");
        
        return $id;
    }
    
    function alur_kas_save($data = array()){
        if(!is_array($data)) return 0;
        if(count($data) == 0) return 0;
        
        $id = (int)$data['id'];
        $created = date("Y-m-d H:i:s", strtotime($data["created"]));
        $creator_user_id = (int)$data['creator_user_id'];        
        $creator_user_name = trim($data["creator_user_name"]);
        $modified = date("Y-m-d H:i:s", strtotime($data["modified"]));
        $modifier_user_id = (int)$data['modifier_user_id'];        
        $modifier_user_name = trim($data["modifier_user_name"]);


        $no_kas_number = trim($data['no_kas_number']);
        $no_kas_number_formatted = trim($data['no_kas_number_formatted']);
        $no_referensi = trim($data['no_referensi']);
        $tanggal = date('Y-m-d', strtotime($data['tanggal']));
        $jumlah_masuk = (int)$data['jumlah_masuk'];
        $jumlah_keluar = (int)$data['jumlah_keluar'];
        $alur_kas = (int)$data['alur_kas'] . "";
        $keterangan = trim($data['keterangan']);
        $tabungan_id = (int)$data['tabungan_id'];
        $kategori_id = (int)$data['kategori_id'];        
        $transfer_id = (int)$data["transfer_id"];
        
        $kode_alur_kas = "";
        if($alur_kas == "1") $kode_alur_kas = "AK/M";
        if($alur_kas == "0") $kode_alur_kas = "AK/K";
        

        $this->db->set("id", $id);
        $this->db->set("created", $created);
        $this->db->set("creator_user_id", $creator_user_id);
        $this->db->set("creator_user_name", $creator_user_name);
        $this->db->set("modified", $modified);
        $this->db->set("modifier_user_id", $modifier_user_id);
        $this->db->set("modifier_user_name", $modifier_user_name);
        
        $this->db->set("no_kas_number", $no_kas_number);
        $this->db->set("no_kas_number_formatted", $no_kas_number_formatted);
        $this->db->set("no_referensi", $no_referensi);
        $this->db->set("tanggal", $tanggal);
        $this->db->set("jumlah_masuk", $jumlah_masuk);
        $this->db->set("jumlah_keluar", $jumlah_keluar);
        $this->db->set("alur_kas", $alur_kas);
        $this->db->set("keterangan", $keterangan);
        $this->db->set("tabungan_id", $tabungan_id);
        $this->db->set("kategori_id", $kategori_id);
        $this->db->set("transfer_id", $transfer_id);
        $this->db->replace("alur_kas");

        if($id == 0){
            $id = $this->db->insert_id();
            
            $no_kas_number = $this->alur_kas_get_next_no_kas_number();
            $no_kas_number_formatted = $this->alur_kas_generate_no_kas_number_formatted($no_kas_number,$kode_alur_kas . "/" . date('y/m') . "/");                                   
                        
            $this->db->set("no_kas_number", $no_kas_number);
            $this->db->set("no_kas_number_formatted", $no_kas_number_formatted);
            $this->db->where("id", $id);
            $this->db->update("alur_kas");                  
        }

        return $id;
    }
    
    function alur_kas_delete_for_transer($transfer_id = 0){
        if($transfer_id == 0) return 0;
        
        $this->db->where("transfer_id", $transfer_id);        
        $this->db->delete("alur_kas");
        
        return $transfer_id;
    }
            
    function alur_kas_get_next_no_kas_number() {

        $sql = "
                    select
                            max(no_kas_number) + 1 next
                        from
                            alur_kas
                  ";
        
        $res = $this->query($sql);
        if(count($res) == 0) return 1;
        
        $next_no_kas_number = (int)$res[0]["next"];
        if($next_no_kas_number == 0) return 1;
        return $next_no_kas_number;
    }
    
    function alur_kas_generate_no_kas_number_formatted($no_kas_number, $prefix) {

        $no_kas_number_formatted = $prefix . str_pad($no_kas_number, 6, 0, STR_PAD_LEFT);
        return $no_kas_number_formatted;
    }
}
