<?php
if(isset($detail) && is_array($detail))
{
  $hash_id = "";
  $title = "";
  $icon = "";
  $link = "";
  $parent_id = 0;
  $title_modal = "New";

  if(count($detail) > 0){
    $hash_id = md5($detail["id"]);
    $title = trim($detail["title"]);
    $icon = trim($detail["icon"]);
    $link = trim($detail["link"]);
    $parent_id = trim($detail["parent_id"]);
    $title_modal = "Edit";
  }
?>
<form id="form-detail" class="form-horizontal" onsubmit="return false">
  <input type="hidden" class="form-control" id="hash_id" name="hash_id" value="<?= $hash_id ?>" />

  <div class="form-group">
    <label class="col-sm-3 control-label">Title</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="title" name="title" value="<?= $title ?>" required />
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Parent Menu</label>
    <div class="col-sm-9">
      <select class="form-control" name="parent_hash_id">
        <option value="" selected>-- Top Menu --</option>
        <?php
          if(isset($parent_list) && is_array($parent_list)){

            foreach($parent_list as $l){

              $selected = "";
              if((int) $l["id"] == $parent_id) $selected = "selected";
              
          ?>
        <option value="<?= md5($l["id"]) ?>"
          <?= $selected ?>>
          <?= $l["title"] ?>
        </option>
        <?php
            }
          }
          ?>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Icon</label>
    <div class="col-sm-9">
      <div class="input-group">
        <span class="input-group-addon">
          <a href="https://www.s-ings.com/typicons/" target="parent">Typicons</a>
        </span>
        <span class="input-group-addon">
          <a href="https://fontawesome.com/icons?d=gallery" target="parent">Fontawesome</a>
        </span>
        <input type="text" class="form-control" id="icon" name="icon" value="<?= $icon ?>" />
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Link</label>
    <div class="col-sm-9">
      <div class="input-group">
        <div class="input-group-addon">
          <span class="input-group-text">
            <?= base_url() ?></span>
        </div>
        <input type="text" class="form-control" id="link" name="link" value="<?= $link ?>" />
      </div>
    </div>
  </div>
</form>

<script>
		$(document).ready(function (){
			$("#modal-title").html("<?= $title_modal ?>");
		});
	</script>
<?php
}