<?php
$level = get_session_for_admin("level");


$pagination_date_start = date('Y-m-01');
$pagination_date_end = date('Y-m-t');


if(isset($_GET['pagination_date_start']) && !empty($_GET['pagination_date_start'])){
    $pagination_date_start = trim($_GET['pagination_date_start']);
}
if(isset($_GET['pagination_date_end']) && !empty($_GET['pagination_date_end'])){
    $pagination_date_end= trim($_GET['pagination_date_end']);
}

$month_year = date('Y-m',  strtotime($pagination_date_start));
$month = (int)date('m', strtotime($month_year . '-01'));
$year = (int)date('Y', strtotime($month_year . '-01'));

if($month == 1){    
    $prev_year = (int) $year - 1;    
    $prev_month = str_pad(12, 2, "0", STR_PAD_LEFT);        
    $prev_date_start = date('Y-m-01', strtotime("$prev_year-$prev_month-01"));
    $prev_date_end = date('Y-m-t', strtotime("$prev_year-$prev_month-01"));            
        
    $next_year = (int) $year;
    $next_month = "02";
    $next_date_start = date('Y-m-01', strtotime("$next_year-$next_month-01"));
    $next_date_end = date('Y-m-t', strtotime("$next_year-$next_month-01"));
} else {
    if($month == 12){
        $next_year = (int) $year +1;
        $next_month = "01";
        $next_date_start = date('Y-m-01', strtotime("$next_year-$next_month-01"));
        $next_date_end = date('Y-m-t', strtotime("$next_year-$next_month-01"));
        
        $prev_month = $month - 1;
        $prev_year = $year;
        $prev_date_start = date('Y-m-01', strtotime("$prev_year-$prev_month-01"));
        $prev_date_end = date('Y-m-t', strtotime("$prev_year-$prev_month-01"));
    }else{        
        $next_year = (int) $year;
        $next_month = $month + 1;
        $next_date_start = date('Y-m-01', strtotime("$next_year-$next_month-01"));
        $next_date_end = date('Y-m-t', strtotime("$next_year-$next_month-01"));
        
        
        $prev_month = $month - 1;
        $prev_year = $year;
        $prev_date_start = date('Y-m-01', strtotime("$prev_year-$prev_month-01"));
        $prev_date_end = date('Y-m-t', strtotime("$prev_year-$prev_month-01"));
    }
}
?>
<div class="row">
    <div class="col-md-6">        
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm">
              <li>
                  <a href="#" onclick="load_alur_kas_list('<?= $prev_date_start ?>', '<?= $prev_date_end ?>')" aria-label="Previous">
                    <span aria-hidden="true"><i class="fa fa-arrow-left"></i></span>
                </a>
              </li>
              <li><a><?= date('F Y', strtotime($month_year . '-01')) ?></a></li>
              <li>
                <a href="#" onclick="load_alur_kas_list('<?= $next_date_start ?>', '<?= $next_date_end ?>')" aria-label="Next">
                  <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
                </a>
              </li>
            </ul>
        </nav>
    </div>
    <div class="col-md-6">
        <h4 style="text-align: right;margin: 10px; margin-top: 20px">Saldo hari ini, <?= date('d F Y') ?>:&nbsp;&nbsp;&nbsp;&nbsp; <b><span style="font-size: 1.4em">Rp. <?= number_format($saldo, 0, ",", ".") ?>,-</span></b></h4>
    </div>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-hover table-striped" id="table-kategori" style="margin: 0;border-top: 0;border-bottom: 0">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>No. Kas</th>
                <th>No. Referensi</th>
                <th>Kategori</th>
                <th>Tabungan</th>
                <th>Keterangan</th>
                <th style="text-align: right">Masuk</th>
                <th style="text-align: right">Keluar</th>
                <!--<th style="text-align: right">Saldo</th>-->
                <th style="width: 80px"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            $saldo = 0;
            foreach ($list as $l) {

    //            if((int)$l['transfer_id'] != 0) continue;

                $jumlah_masuk = (double)$l['jumlah_masuk'];
                $jumlah_keluar = (double)$l['jumlah_keluar'];            

                if($jumlah_masuk < 0) $jumlah_masuk = 0;
                if($jumlah_keluar < 0) $jumlah_keluar = 0;

                if($jumlah_masuk != 0) $saldo += $jumlah_masuk;
                if($jumlah_keluar != 0) $saldo -= $jumlah_keluar;

                $keterangan = trim($l['keterangan']);
                $kategori = trim($l['nama_kategori']);
                if((int)$l['transfer_id'] == 0){
                    $keterangan = trim($l['keterangan']);
                }else{                
                    $kategori = "<i style='color:#888'>TRANSFER ANTAR TABUNGAN</i>";
                    if(empty($keterangan)) {                    
                        $keterangan = "Transfer Antar Tabungan";
                    }
                }
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= date('d M Y', strtotime(trim($l['tanggal']))) ?></td>
                <td><?= trim($l['no_kas_number_formatted']) ?></td>
                <td><?= trim($l['no_referensi']) ?></td>
                <td><?= $kategori ?></td>
                <td><?= trim($l['nama_tabungan']) ?></td>
                <td><?= $keterangan ?></td>
                <td align="right">Rp. <?= number_format($jumlah_masuk, 0, ",", ".") ?></td>
                <td align="right">Rp. <?= number_format($jumlah_keluar, 0, ",", ".") ?></td>
                <!--<td align="right">Rp. <?= number_format($saldo, 0, ",", ".") ?></td>-->
                <td style="width: 80px;">
                <?php 
                    if($level == "Administrator"){ 
                        if((int) $l['transfer_id'] == 0){
                ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-primary" title="Ubah" onclick="load_alur_kas_detail('<?= md5($l['id']) ?>')"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-xs btn-danger" title="Hapus" onclick="delete_alur_kas('<?= md5($l['id']) ?>')"><i class="fa fa-times"></i></button>
                    </div>
                <?php                 
                        }
                    } 
                ?>
                </td>
            </tr>
            <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>