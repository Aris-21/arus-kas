<?php
$hash_id = "";
$nama = "";
$keterangan = "";
  
$modal_title = "Tambah";

if(isset($detail) && is_array($detail) && count($detail) > 0){
    $hash_id = md5($detail['id']);    
    $nama = trim($detail['nama']);
    $keterangan = trim($detail['keterangan']);
    
    $modal_title = "Edit";
}

?>
  <form id="form-detail" class="form-horizontal" onsubmit="return false">
    <input type="hidden" class="form-control" id="hash_id" name="hash_id" value="<?= $hash_id ?>" />

    <div class="form-group">
      <label class="col-sm-3 control-label">Nama</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Keterangan</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $keterangan ?>">
      </div>
    </div>
  </form>

  <hr/>

  <div class="row">
    <div class="col-md-6">
      <?php if(!empty($hash_id)){ ?>
        <button type="button" class="btn btn-sm btn-danger" onclick="confirm_delete('<?= $hash_id ?>')"><i class="fa fa-trash-o"></i>Hapus</button>        
      <?php } ?>
    </div>
    <div class="col-md-6" style="text-align: right">
      <button type="button" onclick="save()" class="btn btn-sm btn-success"><i class='fa fa-save'></i>&nbsp;Simpan</button>                  
    </div>
  </div>

  <script>
    $(document).ready(function (){      
      $("span#modal-title").html("<?= $modal_title ?>");      
    });
  </script>
<?php
