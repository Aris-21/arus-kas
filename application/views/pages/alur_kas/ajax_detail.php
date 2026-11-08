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

$modal_title = "Tambah";

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
    
    if($alur_kas == "1") $jumlah = $jumlah_masuk;
    if($alur_kas == "0") $jumlah = $jumlah_keluar;
    
    $tanggal = date('Y-m-d', strtotime($detail['tanggal']));

    $modal_title = "Edit";

    $alur_kas_readonly = "disabled";
}
?>
<form id="form-detail" class="form-horizontal" onsubmit="return false">
    <input type="hidden" name="hash_id" value="<?= $hash_id ?>"/>    
    <div class="form-group">
        <label class="control-label col-md-3">No. Kas</label>
        <div class="col-md-9">
            <input class="form-control" value="<?= $no_kas_number_formatted ?>" type="text" disabled readonly/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">No. Referensi</label>
        <div class="col-md-9">
            <input class="form-control" name="no_referensi" type="text" value="<?= $no_referensi ?>" required/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Tanggal</label>
        <div class="col-md-9">
            <div class="input-group">                
                <input type="text" class="form-control" name="tanggal" placeholder="mm/dd/yyyy" id="datepicker-tanggal" value="<?= date("m/d/Y", strtotime($tanggal)) ?>">
                <span class="input-group-addon bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
            </div><!-- input-group -->
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3">Alur Kas</label>
        <div class="col-md-9">                
            <div class="radio-inline">
                <label><input type="radio" name="alur_kas" value="MASUK" <?= $alur_kas_readonly ?>
                    <?= $alur_kas == "1" ? "checked" : "" ?>
                              />&nbsp;Masuk</label>
            </div>
            <div class="radio-inline">                    
                <label><input type="radio" name="alur_kas" value="KELUAR" <?= $alur_kas_readonly ?>
                    <?= $alur_kas == "0" ? "checked" : "" ?>
                              />&nbsp;Keluar</label>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Kategori</label>
        <div class="col-md-9">
            <select class="form-control" name="kategori_hash_id" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <?php 
                foreach ($kategori_list as $l) { 
                    $selected = "";
                    if($kategori_id == (int)$l['id']) $selected = "selected";
                ?>
                <option value="<?= md5($l['id']) ?>" <?= $selected ?>><?= $l['alur_kas'] ?> - <?= $l['nama'] ?></option>                        
                <?php } ?>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Tabungan</label>
        <div class="col-md-9">
            <select class="form-control" name="tabungan_hash_id" required>
                <option value="" disabled selected>Pilih Tabungan</option>
                <?php 
                foreach ($tabungan_list as $l) { 
                    $selected = "";
                    if($tabungan_id == (int)$l['id']) $selected = "selected";
                ?>
                <option value="<?= md5($l['id']) ?>" <?= $selected ?>><?= $l['nama'] ?></option>                        
                <?php } ?>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Jumlah</label>
        <div class="col-md-9">
            <input class="form-control" name="jumlah" type="number" value="<?= $jumlah ?>"/>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Keterangan</label>
        <div class="col-md-9">
            <input class="form-control" name="keterangan" type="text" value="<?= $keterangan ?>"/>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-md-6">
            <?php if(!empty($hash_id)){ ?>
            <button type="button" class="btn btn-danger btn-sm" onclick="confirm_delete('<?= $hash_id ?>')"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
            <?php } ?>
        </div>
        <div class="col-md-6" style="text-align: right">
            <button type="button" class="btn btn-success btn-sm" onclick="save()"><i class="fa fa-save"></i>&nbsp; Simpan</button>
        </div>
    </div>
</form>

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