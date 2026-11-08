<?php
$hash_id = "";
$no_kas_number_formatted = "Otomatis";
$no_referensi = "";
$keterangan = "";
$alur_kas = "1";
$tabungan_id = 0;
$kategori_id = 0;
$jumlah = 0;
$tanggal = date('Y-m-d');
$transfer_id = 0;

$modal_title = "Lihat";

$kategori_nama = "";
$tabungan_nama = "";

$alur_kas_readonly = "";

if(isset($detail) && is_array($detail) && count($detail) > 0){
    $hash_id = md5($detail['id']);    
    $no_kas_number_formatted = trim($detail['no_kas_number_formatted']);
    $no_referensi = trim($detail['no_referensi']);
    $keterangan = trim($detail['keterangan']);
    $alur_kas = trim($detail['alur_kas']);
    $jumlah_masuk = (double)$detail['jumlah_masuk'];
    $jumlah_keluar = (double)$detail['jumlah_keluar'];
    $tabungan_id = (int)$detail['tabungan_id'];
    $kategori_id = (int)$detail['kategori_id'];
    $transfer_id = (int) $detail["transfer_id"];

    $kategori_nama = trim($detail["nama_kategori"]);
    $tabungan_nama = trim($detail["nama_tabungan"]);
    
    if($alur_kas == "1") $jumlah = $jumlah_masuk;
    if($alur_kas == "0") $jumlah = $jumlah_keluar;
    
    $tanggal = date('Y-m-d', strtotime($detail['tanggal']));

    $modal_title = "Lihat";

    $alur_kas_readonly = "disabled";

    if($transfer_id > 0){
        $kategori_nama = "Transfer";
    }
}
?>
<div id="form-detail" class="form-horizontal" onsubmit="return false">
    <input type="hidden" name="hash_id" value="<?= $hash_id ?>"/>    
    <div class="form-group">
        <label class="control-label col-md-3">No. Kas</label>
        <div class="col-md-9">
            <input class="form-control" value="<?= $no_kas_number_formatted ?>" type="text" disabled/>
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
        <label class="control-label col-md-3">Alur Kas</label>
        <div class="col-md-9">                
            <input class="form-control" type="text" value="<?= (int) $alur_kas == 1 ? "Masuk" : "Keluar"  ?>" disabled/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Kategori</label>
        <div class="col-md-9">
            <input class="form-control" type="text" value="<?= $kategori_nama ?>" disabled/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Tabungan</label>
        <div class="col-md-9">
            <input class="form-control" type="text" value="<?= $tabungan_nama ?>" disabled/>
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
            <input class="form-control" name="keterangan" type="text" value="<?= $keterangan ?>" disabled/>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6" style="text-align: right">
            <button type="button" class="btn btn-default btn-sm" onclick="$('#modal-view').modal('hide')"><i class="fa fa-times"></i>&nbsp; Tutup</button>
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

        try{
            $(".combobox").combobox();
            
            // datepicker
            $('.datepicker').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                format:'DD-MM-YYYY'
            });
            $('.datepicker input').click(function(event){
                $('.datepicker ').data("DateTimePicker").show();
            });
            $('.datepicker input').focus(function(event){
                $('.datepicker ').data("DateTimePicker").show();
            });
        }catch(e){

        }
    });
</script>