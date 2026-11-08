<?php
if(isset($detail) && is_array($detail))
{
  $hash_id = "";
  $username = "";
  $name = "";
  $user_login_level_id = 0;
  $modal_title = "New";

  if(count($detail) > 0)
  {
    $hash_id = md5($detail["id"]);
    $username = trim($detail["username"]);
    $name = trim($detail["name"]);
    $user_login_level_id = (int) $detail["user_login_level_id"];
    $modal_title = "Edit";
  }
?>
  <form id="form-detail" class="form-horizontal" onsubmit="return false">
    <input type="hidden" class="form-control" id="hash_id" name="hash_id" value="<?= $hash_id ?>" />    

    <div class="form-group">
      <label class="col-sm-3 control-label">Name</label>
      <div class="col-sm-9">
        <input type="text" class="form-control " id="name" name="name" value="<?= $name ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Username</label>
      <div class="col-sm-9">
        <input type="text" class="form-control " id="username" name="username" value="<?= $username ?>" required />
      </div>
    </div>

    <?php if(empty($hash_id)){ ?>
    <div class="form-group">
      <label class="col-sm-3 control-label">Password</label>
      <div class="col-sm-9">
        <input type="password" class="form-control " id="password" name="password" required />
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Retype Password</label>
      <div class="col-sm-9">
        <input type="password" class="form-control " id="retype_password" name="retype_password" required />
      </div>
    </div>
    <?php } ?>

    <div class="form-group">
      <label class="col-sm-3 control-label">Level</label>
      <div class="col-sm-9">
        <select class="form-control " name="user_login_level_hash_id">
          <option value="" disabled selected>-- Select Level --</option>
          <?php
          if(isset($user_login_level_list) && is_array($user_login_level_list))
          {
            foreach($user_login_level_list as $l)
            {
              $selected = "";
              if((int) $l["id"] == $user_login_level_id) $selected = "selected";
          ?>
          <option value="<?= md5($l["id"]) ?>" <?= $selected ?>><?= $l["name"] ?></option>
          <?php
            }
          }
          ?>
        </select>
      </div>
    </div>
  </form>

  <script>
    $(document).ready(function (){
      $("#modal-title").html("<?= $modal_title ?>");
      $("#employee-number-formatted").on("keyup", function (e){
        if(e.keyCode == 13){  
          get_employee_name();
        }
      });
    });

    function get_employee_name(){
      ajax_get(
        '<?= base_url("user_login/ajax_get_employee_name_for_employee_number_formatted") ?>',
        {
          employee_number_formatted: $("#employee-number-formatted").val()
        }, 
        function (resp){
          try {
            var json = JSON.parse(resp);
            if(json.is_success == 1){
                var data = json.data;
                var name = data.name;                
                $("#employee-name").val(name);
            }else{
                show_toast("Error",json.message, "error");
            }
          } catch (error) {
            show_toast("Error", "Application response error");
          }
        }
      );
    }
  </script>
<?php
}