<?php
if(isset($list) && is_array($list) && count($list) > 0)
{
  $i=1;
  foreach ($list as $l) 
  { ?>
    <tr>
      <td>
        <a class="text-primary" onclick="load_detail('<?= md5($l["id"]) ?>')"><i class='fa fa-edit'></i></a> &nbsp;
        <a class="text-danger" onclick="confirm_delete('<?= md5($l["id"]) ?>')"><i class='fa fa-trash'></i></a>
      </td>
      <td><?= $i ?></td>
      <td><?= $l["name"] ?></td>
      <td><?= $l["username"] ?></td>
      <td><?= $l["user_login_level_name"] ?></td>
      <td>
        <button type="button" class="btn btn-sm btn-warning" onclick="$('#modal-reset-password-<?= md5($l["id"]) ?>').modal('show')"><i class='fa fa-lock'></i>&nbsp;Reset Password</button>
        <div class="modal" id="modal-reset-password-<?= md5($l["id"]) ?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title">Reset Password</h3>
              </div>
              
              <div class="modal-body" id="modal-reset-password-body">
                <form id="form-reset-password-<?= md5($l["id"]) ?>" class="form-horizontal" onsubmit="return false">
                  <input type="hidden" class="form-control" id="hash_id" name="hash_id" value="<?= md5($l["id"]) ?>" />
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control input-sm" id="password" name="password" required />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Retype Password</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control input-sm" id="retype_password" name="retype_password" required />
                    </div>
                  </div>
                </form>
              </div>

              <div class="modal-footer">
                <button type="button" onclick="reset_password('<?= md5($l["id"]) ?>')" class="btn btn-sm btn-primary"><i class='fa fa-save'></i>&nbsp;Save changes</button>                  
              </div>
            </div>
          </div><!-- modal-dialog -->
        </div><!-- modal -->
      </td>
    </tr>
    <?php
    $i++;
  }
} else { 
?>
<tr>
  <td colspan="7">No Data</td>
</tr>
<?php
}