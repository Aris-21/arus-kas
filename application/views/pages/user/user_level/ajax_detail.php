<?php
if(isset($detail) && is_array($detail)){
  $hash_id = "";
  $name = "";
  $allowed_method_list = array();
  $allowed_menu_list = array();
  $title_modal = "New";

  if(count($detail) > 0){
    $hash_id = md5($detail["id"]);
    $name = trim($detail["name"]);
    $allowed_method_list = json_decode($detail['privilege_json'], true);
    $allowed_menu_list = json_decode($detail["menu_json"], true);    
    $title_modal = "Edit";
  }
?>
<form id="form-detail" class="form-horizontal" onsubmit="return false">
  <input type="hidden" class="form-control" id="hash_id" name="hash_id" value="<?= $hash_id ?>" />
  <div class="form-group">
    <label class="col-sm-3 control-label">Name</label>
    <div class="col-md-9">
      <input type="text" class="form-control " id="name" name="name" value="<?= $name ?>" required />
    </div>
  </div>

  <ul class="nav nav-tabs">
    <li role="presentation" class="active">
        <a role="tab" data-toggle="tab" href="#tabPrivilege">Privilege</a>
    </li>
    <li role="presentation">
        <a role="tab" data-toggle="tab" href="#tabMenu">Menu</a>
    </li>
  </ul>
  <div class="tab-content">
    <div id="tabPrivilege" class="tab-pane fade in active" role="tabpanel">
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive" style="max-height: calc(100vh - 325px);overflow-y: auto">
            <?php
              $method_list = get_all_method_for_each_controllers(""); 
            ?>
            <table class="table table-bordered table-stripedx table-hover">
              <tbody>
                <?php
                foreach ($method_list as $controller_name => $function_list) 
                {   
                  $parent_checked = "";
                  if(isset($allowed_method_list[$controller_name]['root']) && 
                    (int)$allowed_method_list[$controller_name]['root'] == 1)
                    {
                      $parent_checked = "checked";
                    }
                ?>
                <tr>
                  <th class="bg-gray" style="font-weight: 500; background-color: #ccc"><?= ucwords(str_replace("_", " ", $controller_name)) ?></th>
                  <th class="bg-gray" style="font-weight: 500;text-align: center; background-color: #ccc" width="100"><input type="checkbox" <?= $parent_checked ?> class="privilege-<?= $controller_name ?>-parent privilege-parent" data-parent_name="<?= $controller_name ?>" name="privilege-<?= $controller_name ?>" /></th>
                </tr>

                <?php                                      
                  if(count($function_list) > 0)
                  {
                    foreach ($function_list as $function_name => $data) 
                    {
                      $label = trim($data['label']);
                      $allow = (bool) $data['allow'];
                      
                      $checked = "";
                      if($allow) $checked = "checked";
                      
                      if(isset($allowed_method_list[$controller_name][$function_name]['allow']) &&
                        (int) $allowed_method_list[$controller_name][$function_name]['allow'] == 1)
                        {
                          $checked = "checked";
                        }                        
                      
                      if($parent_checked) $checked = "checked";
                ?>
                <tr>
                  <td><i class="fa fa-chevron-right"></i>&nbsp;<?= $label ?></td>
                  <td style="text-align: center">
                    <input name="privilege-<?= $controller_name ?>-item[]" value="<?= $function_name ?>" class="privilege-<?= $controller_name ?>-item privilege-item" data-parent_name="<?= $controller_name ?>" type="checkbox" <?= $checked ?>/>
                  </td>
                </tr>

                <?php
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div><!-- tab-pane -->

    <div id="tabMenu" class="tab-pane fade" role="tabpanel">
      <div class="row row-xs align-items-center mg-b-10">
        <div class="col-md-12">
          <div class="table-responsive" style="max-height: calc(100vh - 325px);overflow-y: auto">
            <table class="table table-bordered table-stripedx table-hover">
              <thead>                          
                <tr>
                  <th class="bg-gray" style="font-weight: 500; background-color: #bbb">Icon</th>
                  <th class="bg-gray" style="font-weight: 500; background-color: #bbb">Title</th>
                  <th class="bg-gray" style="font-weight: 500; background-color: #bbb">Link</th>
                  <th class="bg-gray" style="font-weight: 500;text-align: center; background-color: #bbb" width="100">Allow</th>
                  <th class="bg-gray" style="font-weight: 500;text-align: center; background-color: #bbb" width="100">Shortcut</th>
                </tr>
              </thead>

              <tbody>
                <?php
                if(isset($user_menu_list) && is_array($user_menu_list) && count($user_menu_list) > 0)
                {
                  // iterate parent
                  foreach ($user_menu_list as $l) 
                  {
                    $id = (int) $l["id"];
                    $parent_id = (int) $l["parent_id"];
                    $icon = trim($l["icon"]);
                    $title = trim($l["title"]);
                    $link = trim($l["link"]);
                    $name = str_replace(" ", "-", strtolower($title));

                    $allow_parent_checked = "";
                    $shortcut_parent_checked = "";

                    if(isset($allowed_menu_list[$id]["allow"])){
                      if($allowed_menu_list[$id]["allow"] == 1) $allow_parent_checked = "checked";
                    }
                    if(isset($allowed_menu_list[$id]["shortcut"])){
                      if($allowed_menu_list[$id]["shortcut"] == 1) $shortcut_parent_checked = "checked";
                    }

                    $child_list = array();
                    if(isset($l["child_list"]) && is_array($l["child_list"])){
                      $child_list = $l["child_list"];
                    }
                ?>
                <tr>
                  <th class="bg-gray" style="font-weight: 500; background-color: #ddd; width: 50"><i class="<?= $icon ?>"></i></th>
                  <th class="bg-gray" style="font-weight: 500; background-color: #ddd"><?= $title ?></th>
                  <th class="bg-gray" style="font-weight: 500; background-color: #ddd"><?= $link ?></th>
                  <th class="bg-gray" style="font-weight: 500;text-align: center; background-color: #ddd" width="100"><input type="checkbox" <?= $allow_parent_checked ?> class="menu-allow-parent-<?= $id ?> menu-allow-parent" data-allow_parent_id="<?= $id ?>" name="menu-allow-parent-<?= $id ?>" /></th>
                  <th class="bg-gray" style="font-weight: 500;text-align: center; background-color: #ddd" width="100"><input type="checkbox" <?= $shortcut_parent_checked ?> class="menu-shortcut-parent-<?= $id ?> menu-shortcut-parent" data-shortcut_parent_id="<?= $id ?>" name="menu-shortcut-parent-<?= $id ?>" /></th>
                </tr>
                <?php
                    foreach ($child_list as $c) 
                    {
                      $id = (int) $c["id"];
                      $parent_id = (int) $c["parent_id"];
                      $icon = trim($c["icon"]);
                      $title = trim($c["title"]);
                      $link = trim($c["link"]);
                      $name = str_replace(" ", "-", strtolower($title));

                      $allow_child_checked = "";
                      $shortcut_child_checked = "";

                      if(isset($allowed_menu_list[$parent_id]["child"][$id]["allow"])){
                        if($allowed_menu_list[$parent_id]["child"][$id]["allow"] == 1) $allow_child_checked = "checked";
                      }
                      if(isset($allowed_menu_list[$parent_id]["child"][$id]["shortcut"])){
                        if($allowed_menu_list[$parent_id]["child"][$id]["shortcut"] == 1) $shortcut_child_checked = "checked";
                      }

                      if($allow_parent_checked == "checked") $allow_child_checked = "checked";
                      if($shortcut_parent_checked == "checked") $shortcut_child_checked = "checked";

                ?>
                <tr>
                  <td style="width: 50"><i class="<?= $icon ?>"></i></td>
                  <td><?= $title ?></td>
                  <td><?= $link ?></td>
                  <th class="bg-gray" style="font-weight: 500;text-align: center" width="100"><input type="checkbox" <?= $allow_child_checked ?> class="menu-allow-child-<?= $id ?> menu-allow-child-parent-<?= $parent_id ?> menu-allow-child" data-allow_child_id="<?= $id ?>" data-allow_child_id='<?= $id ?>' data-allow_parent_id="<?= $parent_id ?>" name="menu-allow-child-<?= $id ?>" /></th>
                  <th class="bg-gray" style="font-weight: 500;text-align: center" width="100"><input type="checkbox" <?= $shortcut_child_checked ?> class="menu-shortcut-child-<?= $id ?> menu-shortcut-child-parent-<?= $parent_id ?> menu-shortcut-child" data-shortcut_child_id="<?= $id ?>" data-shortcut_child_id='<?= $id ?>' data-shortcut_parent_id="<?= $parent_id ?>" name="menu-shortcut-child-<?= $id ?>" /></th>
                </tr>
                <?php
                    }
                  }
                }
                ?>                      
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>  
</form>

<script>
  $(document).ready(function(){
      $(".privilege-item").change(function(){
          var parent_name = $(this).data("parent_name");
          var checked = $(this).prop("checked");            
          if(!checked){
              $(".privilege-" + parent_name + "-parent").prop("checked", false);
          }
                      
          var item_length = $(".privilege-"+ parent_name +"-item").length;
          var checked_count = $(".privilege-"+ parent_name +"-item:checked").length;
                              
          if(item_length === checked_count){
              $(".privilege-"+ parent_name +"-parent").prop("checked", true);                
          }else{
              $(".privilege-"+ parent_name +"-parent").prop("checked", false);
          }
      });

      $("#modal-title").html("<?= $title_modal ?>");              
      
      $(".privilege-parent").change(function(){
          var checked = $(this).prop("checked");
          var name = $(this).data("parent_name");
          $(".privilege-" + name + "-item").prop("checked", checked);
          $(".privilege-" + name + "-item").prop("disabled", checked);
      });

      $(".menu-allow-parent").change(function (){
        var checked = $(this).prop("checked");
        var id = $(this).data("allow_parent_id");

        $(".menu-allow-child-parent-" + id).prop("checked", checked);
        $(".menu-allow-child-parent-" + id).prop("disabled", checked);

        if(!checked){
          $(".menu-shortcut-child-parent-" + id).prop("checked", false);          
          $(".menu-shortcut-parent-" + id).prop("checked", false);          
        }
      });

      $(".menu-shortcut-parent").change(function (){
        var checked = $(this).prop("checked");
        var id = $(this).data("shortcut_parent_id");

        var allow_checked = $(".menu-allow-parent-" + id).prop("checked");        
        if(checked) checked = allow_checked;
        
        if(!checked) $(this).prop("checked", false);
        $(".menu-shortcut-child-parent-" + id).prop("checked", checked);
        $(".menu-shortcut-child-parent-" + id).prop("disabled", checked);        
      });

      $(".menu-allow-child").change(function (){
        var checked = $(this).prop("checked");
        var id = $(this).data("allow_child_id");
        var parent_id = $(this).data("allow_parent_id");

        // **
        // uncheck shortcut if allow is unchecked
        if(!checked){
          $(".menu-shortcut-child-" + id).prop("checked", false);
        }

        // **
        // if all child are checked then check they parent, else revert
        var child_length = $(".menu-allow-child-parent-" + parent_id).length;        
        var child_checked_length = $(".menu-allow-child-parent-" + parent_id + ":checked").length;
        
        $(".menu-allow-parent-" + parent_id).prop("checked", child_checked_length > 0);
      });

      $(".menu-shortcut-child").change(function (){
        var checked = $(this).prop("checked");
        var id = $(this).data("shortcut_child_id");
        var parent_id = $(this).data("shortcut_parent_id");

        var allow_checked = $(".menu-allow-child-" + id).prop("checked");   
        if(!allow_checked) checked = false;
        $(this).prop("checked", checked);

        // **
        // if all child are checked then check they parent, else revert
        var child_length = $(".menu-shortcut-child-parent-" + parent_id).length;        
        var child_checked_length = $(".menu-shortcut-child-parent-" + parent_id + ":checked").length;
        
        $(".menu-shortcut-parent-" + parent_id).prop("checked", child_checked_length > 0);
      });
  });
</script>
<?php
}