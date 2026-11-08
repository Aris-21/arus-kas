<?php
$hash_id = "";
$tanggal = date('Y-m-d');
$no_transfer = "Otomatis";
$no_referensi = "";
$keterangan = "";
$jumlah = 0;
$tabungan_sumber_id = 0;
$tabungan_tujuan_id = 0;
$tabungan_sumber_nama = "";
$tabungan_tujuan_nama = "";

$modal_title = "Lihat";

if(isset($detail) && is_array($detail) && count($detail) > 0){
    $hash_id = md5($detail['id']);    
    $tanggal = date('Y-m-d', strtotime(trim($detail['tanggal'])));
    $no_transfer = trim($detail['no_transfer_number_formatted']);
    $no_referensi = trim($detail['no_referensi']);
    $keterangan = trim($detail['keterangan']);    
    $jumlah = (double)$detail['jumlah'];    
    $tabungan_sumber_id = (int)$detail['tabungan_sumber_id'];
    $tabungan_tujuan_id = (int)$detail['tabungan_tujuan_id'];
    $nama_tabungan_sumber = trim($detail['nama_tabungan_sumber']);    
    $nama_tabungan_tujuan = trim($detail['nama_tabungan_tujuan']);    

    $modal_title = "Lihat";
}

?>
<div id="form-detail" class="form-horizontal" onsubmit="return false">
    <input type="hidden" name="hash_id" value="<?= $hash_id ?>"/>    
    <div class="form-group">
        <label class="control-label col-md-3">No.</label>
        <div class="col-md-9">
            <input class="form-control" disabled value="<?= $no_transfer ?>"/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">No. Referensi</label>
        <div class="col-md-9">
            <input class="form-control" type="text" value="<?= $no_referensi ?>" disabled/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Tanggal</label>
        <div class="col-md-9">
            <input class="form-control" type="text" value="<?= date("d M Y", strtotime($tanggal)) ?>" disabled/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Dari (Tabungan)</label>
        <div class="col-md-9">
            <input class="form-control" type="text" value="<?= $nama_tabungan_sumber ?>" disabled/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Ke (Tabungan)</label>
        <div class="col-md-9">
            <input class="form-control" type="text" value="<?= $nama_tabungan_tujuan ?>" disabled/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Jumlah</label>
        <div class="col-md-9">
            <input class="form-control" type="text" value="Rp. <?= number_format($jumlah, 0, ",", ".") ?>" disabled/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Keterangan</label>
        <div class="col-md-9">
            <input class="form-control" value="<?= $keterangan ?>" disabled/>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6" style="text-align: right">
            <button type="button" class="btn btn-success btn-sm" onclick="$('#modal-view').modal('hide')"><i class="fa fa-times"></i>&nbsp; Tutup</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){         
        $("span#modal-title").html("<?= $modal_title ?>");      

        $('#datepicker-tanggal').datepicker({
            autoclose: true,
            todayHighlight: true
        });      
    });
</script>