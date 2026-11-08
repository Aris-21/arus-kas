<?php
$hash_id = "";
$tanggal = date('Y-m-d');
$no_transfer = "Otomatis";
$no_referensi = "";
$keterangan = "";
$jumlah = 0;
$tabungan_sumber_id = 0;
$tabungan_tujuan_id = 0;

$modal_title = "Tambah";

if(isset($detail) && is_array($detail) && count($detail) > 0){
    $hash_id = md5($detail['id']);    
    $tanggal = date('Y-m-d', strtotime(trim($detail['tanggal'])));
    $no_transfer = trim($detail['no_transfer_number_formatted']);
    $no_referensi = trim($detail['no_referensi']);
    $keterangan = trim($detail['keterangan']);    
    $jumlah = (double)$detail['jumlah'];    
    $tabungan_sumber_id = (int)$detail['tabungan_sumber_id'];
    $tabungan_tujuan_id = (int)$detail['tabungan_tujuan_id'];

    $modal_title = "Edit";
}

?>
<form id="form-detail" class="form-horizontal" onsubmit="return false">
    <input type="hidden" name="hash_id" value="<?= $hash_id ?>"/>    
    <div class="form-group">
        <label class="control-label col-md-3">No.</label>
        <div class="col-md-9">
            <input class="form-control" disabled readonly value="<?= $no_transfer ?>"/>
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
        <label class="control-label col-md-3">Dari (Tabungan)</label>
        <div class="col-md-9">
            <select class="form-control" name="tabungan_sumber_hash_id" required>
                <option value="" disabled selected>Pilih Tabungan Sumber</option>
                <?php 
                foreach ($tabungan_list as $l) { 
                    $selected = "";
                    if($tabungan_sumber_id == (int)$l['id']) $selected = "selected";
                ?>
                <option value="<?= md5($l['id']) ?>" <?= $selected ?>><?= $l['nama'] ?></option>                        
                <?php } ?>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3">Ke (Tabungan)</label>
        <div class="col-md-9">
            <select class="form-control" name="tabungan_tujuan_hash_id" required>
                <option value="" disabled selected>Pilih Tabungan Tujuan</option>
                <?php 
                foreach ($tabungan_list as $l) { 
                    $selected = "";
                    if($tabungan_tujuan_id == (int)$l['id']) $selected = "selected";
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
            <input class="form-control" name="keterangan" value="<?= $keterangan ?>"/>
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
    });
</script>