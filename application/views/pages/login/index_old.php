
<!DOCTYPE html>
<html lang="en">
  <head>    
    <?php view("templates/meta") ?>
    <?php view("templates/style") ?>

  </head>
  <body class="az-body">

    <div class="az-signin-wrapper">
      <div class="az-card-signin">        
        <div class="az-signin-header">
          <h2>SDIT Citra Ummat</h2>
          <h4>Please log in to continue</h4>

          <form onsubmit="return false" id="form-login">
            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control" name="username" placeholder="Enter your username" value="">
            </div><!-- form-group -->
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter your password" value="">
            </div><!-- form-group -->
            <button type="button" class="btn btn-az-primary btn-block" onclick="do_login()">Log In</button>
          </form>
        </div><!-- az-signin-header -->
      </div><!-- az-card-signin -->
    </div><!-- az-signin-wrapper -->

    <?php view("templates/script") ?>
    <script>
      $(function(){
        'use strict'
      });

      function do_login(){
        var form_data = $("#form-login").serializeArray();
        ajax_post(
            '<?= base_url() ?>login/do_login', 
            form_data, function(resp){                
                try{
                    var json = JSON.parse(resp);
                    var is_success = json.is_success;
                    var message = json.message;

                    if(is_success == 1){
                        show_toast("Success", "Mengarahkan ke halaman utama ...", "success");
                        window.location.href = "<?= base_url("") ?>";
                    }
                }catch(error){
                    show_toast("Error", "Application Response Error", "error");
                }
            });
      }
    </script>
  </body>
</html>
