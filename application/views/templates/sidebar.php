<?php

$level = get_session("level");
$user = get_session("user");
$allow_menu_list = get_session("allow_menu_list");

$special_char_list = array("&", "/", ";", " ");
?>

<style>
/*    .side-menu{
        background-color: #253138;
    }
    
    .user-box{
        border-bottom-color: #333;
    }
    
    #sidebar-menu .subdrop{
        background-color: #1c2327;
    }
    
    #sidebar-menu > ul > li > a{
        background-color: #253138;
        color: #ccc;
    }
    
    .topbar-left{
        background: #253138 !important;
        
    }*/
</style>

<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!-- User -->
        <div class="user-box">
            <div class="user-img hidden">
                <img src="assets/images/users/avatar-1.jpg" alt="user-img" title="<?= $user["name"] ?>" class="img-circle img-thumbnail img-responsive">
                <div class="user-status offline"><i class="zmdi zmdi-dot-circle"></i></div>
            </div>
            <h5><a href="javascript:void(0)"><?= $user["name"] ?></a> </h5>
            <h6><?= $user["user_login_level_name"] ?></h6>
            <ul class="list-inline">
                <!-- <li>
                    <a href="#" >
                        <i class="zmdi zmdi-settings"></i>
                    </a>
                </li> -->

                <li>
                    <a href="<?= base_url("login/do_logout") ?>" title="Keluar" class="text-custom" title="Keluar">
                        <i class="fa fa-power-off"></i>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="$('#modal-ganti-password').modal('show')" title="Ganti Password" class="text-custom" title="Keluar">
                        <i class="fa fa-key"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End User -->

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="text-muted menu-title">Navigation</li>

                <?php
                $active = "active";    
                foreach ($allow_menu_list as $id => $p) {
                  $title = $p["title"];
                  $icon = $p["icon"];
                  $link = $p["link"];
                  $allow = (int) $p["allow"];
                  $shortcut = (int) $p["shortcut"];

                  if($allow == 0) continue;

                  $name = str_replace($special_char_list, "-", strtolower($title));

                  $child_list = $p["child"];

                  if(count($child_list) > 0){
                ?>

                <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="<?= $icon ?>"></i> <span> <?= $title ?> </span> <span class="menu-arrow"></span></a>
                  <ul class="list-unstyled">
                  <?php
                    foreach ($child_list as $child_id => $c) {          
                      $allow = (int) $c["allow"];
                      $shortcut = (int) $c["shortcut"];
                      $link = trim($c["link"]);
                      $title = trim($c["title"]);

                      if(empty($link)){
                        $link = "javascript:void(0);";
                      }else{
                        $link = base_url($link);
                      }

                      if($allow == 0) continue;
                      ?>
                      <li><a href="<?= $link ?>"><?= $title ?></a></li>
                      <?php
                    }                
                  ?>
                  </ul>
                </li>

                <?php
                  } else{
                    if(empty($link)){
                      $link = "javascript:void(0);";
                    }else{
                      $link = base_url($link);
                    }
                ?>
                <li>
                    <a href="<?= $link ?>" class="waves-effect"><i class="<?= $icon ?>"></i> <span> <?= $title ?> </span> </a>
                </li>
                <?php
                  }
                }
                ?>     

                <?php if($level == "Super Administrator"){ ?>
                <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cogs"></i> <span> System Settings </span> <span class="menu-arrow"></span></a>
                  <ul class="list-unstyled">
                    <li><a href="<?= base_url("user_level") ?>">User Level</a></li>
                    <li><a href="<?= base_url("user_menu") ?>">User Menu</a></li>
                  </ul>
                </li>
                <?php } ?>           
            </ul>
            <div class="clearfix"></div>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->


<div class="modal fade" id="modal-ganti-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title"><span id="modal-title"></span> Ganti Password</h3>
      </div>

      <div class="modal-body" id="modal-ganti-password-body">
        <form id="form-ganti-password" onsubmit="return false" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-3 control-label">Password lama</label>
            <div class="col-sm-9">
              <input type="password" name="old_password" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Password baru</label>
            <div class="col-sm-9">
              <input type="password" name="new_password" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Ulangi password baru</label>
            <div class="col-sm-9">
              <input type="password" name="confirm_password" class="form-control" required />
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" onclick="do_change_password()" class="btn btn-sm btn-primary"><i class='fa fa-save'></i>&nbsp;Update</button>                  
      </div>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->

<script>
  

  function do_change_password(){
    var form_data = $("#form-ganti-password").serializeArray();
    ajax_post(
      "<?= base_url("user_login/ajax_change_password") ?>",
      form_data, 
      function(resp){
        try {
            var json = JSON.parse(resp);
            if(json.is_success == 1){
                show_toast("Success", json.message, "success");
                $("#modal-ganti-password").modal("hide");
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