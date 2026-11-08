
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php view("templates/meta") ?>    
    <?php view("templates/style") ?>    
  </head>
  <body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">

      <?php view("templates/header") ?>
      <?php view("templates/sidebar") ?>

      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="content-page">
        <!-- Start content -->
        <div class="content">
          <div class="container">

          <div class="row">
            <div class="col-md-12">

              <div class="panel panel-custom panel-border">
                <div class="panel-heading with-border">                                  
                  <div class="pull-right">
                    <button type="button" class="btn btn-sm btn-primary" onclick="load_detail('')"><i class="fa fa-plus"></i>&nbsp; Add new</button>            
                  </div>

                  <h3 class="panel-title">User Level</h3>                  
                </div>
                <div class="panel-body">
                  <div class="table-responsive mt-3">
                    <table class="table table-striped table-dashboard-two mg-b-0">
                      <thead>
                        <tr>
                          <th style="width: 60px"></th>
                          <th style="width: 40px">#</th>
                          <th>Name</th>
                          <th>Username</th>
                          <th>Level</th>
                          <th></th>
                        </tr>
                      </thead>

                      <tbody id="table-body-data">                
                      </tbody>
                    </table>
                  </div><!-- table-responsive -->
                </div>
              </div>

            </div>
          </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3 class="modal-title"><span id="modal-title"></span> User Login</h3>
            </div>

            <div class="modal-body" id="modal-detail-body">                  
            </div>

            <div class="modal-footer">
              <button type="button" onclick="save()" class="btn btn-sm btn-primary"><i class='fa fa-save'></i>&nbsp;Save changes</button>                  
            </div>
          </div>
        </div><!-- modal-dialog -->
      </div><!-- modal -->

      <?php view("templates/footer") ?>
    </div><!-- az-content -->

    <?php view("templates/script") ?>

    <script>
      $(document).ready(function (){
        $("#app-header-title").html("User Login");

        load_list();
      });

      function load_list(){
        ajax_get(
          "<?= base_url('user_login/ajax_list') ?>",
          {}, 
          function (resp){
            $("#table-body-data").html(resp);
          }
        );
      }

      function load_detail(hash_id){
        ajax_get(
          "<?= base_url('user_login/ajax_detail') ?>/" + hash_id,
          {}, 
          function (resp){
            $("#modal-detail").modal("show");
            $("#modal-detail-body").html(resp);
          }
        );
      }

      function save(){
        var form_data = $("#form-detail").serializeArray();
        ajax_post(
          "<?= base_url("user_login/ajax_save") ?>",
          form_data, 
          function (resp){
            try {
                var json = JSON.parse(resp);
                if(json.is_success == 1){
                    show_toast("Success", json.message, "success");
                    $("#modal-detail").modal("hide");
                    load_list();
                }else{
                    show_toast("Error",json.message, "error");
                }
            } catch (error) {
              show_toast("Error", "Application response error");
            }
          }
        );
      }

      function reset_password(hash_id){
        var form_data = $("#form-reset-password-" + hash_id).serializeArray();
        ajax_post(
          "<?= base_url("user_login/ajax_reset_password") ?>",
          form_data, 
          function (resp){
            try {
                var json = JSON.parse(resp);
                if(json.is_success == 1){
                    show_toast("Success", json.message, "success");
                    $("#modal-reset-password-" + hash_id).modal("hide");
                    // load_list();
                }else{
                    show_toast("Error",json.message, "error");
                }
            } catch (error) {
              show_toast("Error", "Application response error");
            }
          }
        );
      }

      function confirm_delete(hash_id){     
        var confirmed = confirm("Are you sure ?");
        if(!confirmed) return false;
        
        ajax_get(
          "<?= base_url("user_login/ajax_delete") ?>/" + hash_id,
          {}, 
          function (resp){
            try {
                var json = JSON.parse(resp);
                if(json.is_success == 1){
                    show_toast("Success", json.message, "success");                    
                    load_list();
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
  </body>
</html>