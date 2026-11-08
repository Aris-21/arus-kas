<!DOCTYPE html>
<html>
    <head>
        <title><?= APP_NAME ?></title>
        <meta name="msapplication-TileColor" content="#ffffff">        
        <meta name="theme-color" content="<?= APP_THEME_COLOR ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" />
        <link href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets/toast/jquery.toast.min.css');?>" rel="stylesheet">
        <!--<link href="https://fonts.googleapis.com/css?family=Italianno" rel="stylesheet">-->
        <link href="https://fonts.googleapis.com/css?family=Mr+De+Haviland" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Marvel" rel="stylesheet">
        
        <script src="<?php echo base_url('assets/jQuery/jquery-2.2.3.min.js')?>"></script>
        <script src="<?php echo base_url('assets/app/js/app.js')?>"></script>
        <script src="<?php echo base_url('assets/toast/jquery.toast.min.js')?>"></script>

        <style>
            body, html{
                height: 100%;
                margin: 0;
                -webkit-font-smoothing: antialiased;
                background-color: <?= APP_THEME_COLOR ?>;      
            }                        
            .login-page{
                /*background-color: #0397ff;*/
                
            }
            
            .login-page-title{
                text-align: center;
                margin-bottom: 20px;                
            }                        
            
            .login-page .login-page-title h1,
            .login-page .login-page-title h2,
            .login-page .login-page-title h3,
            .login-page .login-page-title h4,
            .login-page .login-page-title h5,
            .login-page .login-page-title h6{
                margin: 0;
                margin-bottom: -10px;
                
                color: #fff;
                font-size: 60px;
                font-weight: 500;
                letter-spacing: 0px;
                /*font-family: 'Italianno', cursive;*/
                /*font-family: 'Mr De Haviland', cursive;*/
                text-shadow: 0 2px 10px rgba(0,0,0,0.2);
                
                
                text-align: center;
                padding: 20px;
            }
            
            .login-page .login-page-title span{
                color: #eee;
                font-size: 18px;                
            }
            
            @media(max-width: 767px){
                .login-page{
                    padding-top: 0px
                }
                
                .login-page .login-page-title h1,
                .login-page .login-page-title h2,
                .login-page .login-page-title h3,
                .login-page .login-page-title h4,
                .login-page .login-page-title h5,
                .login-page .login-page-title h6{
                    font-size: 40px;
                }
            }
            
            .login-box{
                border-radius: 10px;
                background-color: #f8f8f8;
                box-shadow: 0 0 20px rgba(0,0,0,0.3);                
                min-height: 100px;
                /*font-family: 'Marvel', sans-serif;*/
                width: 100%;
                margin-bottom: 40px;                
            }            
            
            .font-marvel{
                font-family: 'Marvel', sans-serif;
            }
            
            .login-box .login-box-header{
                border-bottom: 1px solid #eee;
                padding: 20px;
            }
            
            .login-box-header h1,
            .login-box-header h2,
            .login-box-header h3,
            .login-box-header h4,
            .login-box-header h5,
            .login-box-header h6{
                font-size: 25px;
                font-weight: 400;
                color: #777;
                margin: 0;
            }                        
            
            .login-box .login-box-body{                
                padding: 20px;
            }
            
            .login-box-body .form-input{
                border-radius: 100px;
                padding: 15px 30px;
                font-size: 14px;
                /*font-weight: 700;*/
                /*color: #0397ff;*/
                color: <?= APP_THEME_COLOR_DARK ?>;
                box-shadow: 0 6px 12px 0 rgba(18, 113, 179, 0.14);
                appearance: none;
                width: 100%;
                border: 0;
                outline: 0;          
                margin-bottom: 10px;
                transition: 0.5s;
            }
            
            ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
                color:    #ccc;
            }
            :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
               color:    #ccc;
               opacity:  1;
            }
            ::-moz-placeholder { /* Mozilla Firefox 19+ */
               color:    #ccc;
               opacity:  1;
            }
            :-ms-input-placeholder { /* Internet Explorer 10-11 */
               color:    #ccc;
            }
            
            .login-box-body .form-input:focus,
            .login-box-body .form-input:hover{
                box-shadow: 0 10px 22px 0 rgba(18, 113, 179, 0.24);
            }
            
            .login-box .login-box-footer{
                border-top: 1px solid #eee;
                padding: 20px;
            }
            
            #forget-password, #sign-up{
                font-size: 14px;   
                margin-top: 10px;
                text-align: center;
            }
            #sign-up{
                margin-bottom: 10px;
            }
            
            .btn-login{
                border-radius: 100px;
                outline: 0;
                border: none;
                text-align: center;
                color: #fff;
                /*background-color: #008ef2;*/
                background-color: <?= APP_THEME_COLOR ?>;
                padding: 10px 20px;
                box-shadow: 0 6px 12px 0 rgba(18, 113, 179, 0.14);
                transition: 0.3s;
                font-size: 15px
            }
            .btn-login:hover,
            .btn-login:focus{
                box-shadow: 0 10px 22px 0 rgba(18, 113, 179, 0.34);                    
                /*background-color: #0080d9;*/
                background-color: <?= APP_THEME_COLOR_DARK ?>;
                padding: 10px 30px;
            }
            
            @media(max-width: 767px){
                .login-box{
                    width: 100%;
                    margin-right: 10%;
                    position: relative;                    
                }
                
                .login-box-footer{
                    text-align: center;
                }
                .btn-login{
                    width:100%;;
                }
                #sign-up{
                    margin-top: 10px; 
                    margin-bottom: 10px;
                    font-size: 16px;
                }              
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-12">
                    <div class="login-page" style="height: 100%">
                        <div class="login-page-title font-marvel">
                            <h1><?= APP_NAME ?></h1>
                            <span></span>
                        </div>
                        <form onsubmit="return false">
                            <div class="login-box">
                                <div class="login-box-header">
                                    <h3 style="text-align: center"><i class="fa fa-search"></i>&nbsp; Verifikasi Email</h3>
                                </div>
                                <div class="login-box-body">
                                    <div class="alert alert-success">
                                        <p class="text-success" id="message" style="font-size: 14px">
                                            Anda telah terdaftar.<br/> Silahkan masukkan kode verifikasi yang telah dikirim ke email anda untuk dapat menggunakan aplikasi ini.
                                            <br/>
                                            Silahkan periksa di folder <b>SPAM</b> jika tidak ada pada kotak masuk.
                                        </p>
                                    </div>
                                    <?php
                                    
                                    // set back form value if isset                                    
                                    $email = $verification['email'];
                                    ?>
                                    <input type="text" name="email" class="form-input" placeholder="Email" required value="<?= $email ?>" id="email"/>
                                    <input type="text" name="verification_code" class="form-input" placeholder="Kode verifikasi" required id="verification-code"/>
                                    
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button type="button" onclick="process_verification()" id="btn-do-verification" class="btn-login btn-block">Verifikasi <i class="fa fa-arrow-right" style="margin-left: 10px"></i></button>                                
                                        </div>
                                    </div>
                                </div>
                                <div class="login-box-footer">                                                            
                                    <div class="text-center" style="margin-top: 20px">
                                        <span>Powered by <a href="http://gutsylab.com">GutsyLab.com</a></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="loader-wrapper" id="loader">
            <div class="load-content">
                Mohon tunggu ...
                <br>
                <br>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .loader-wrapper{
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.3);
                z-index: 2000;
                display: none;
            }

            .loader-wrapper .load-content{
                position: fixed;
                z-index: 2001;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);

                width: 300px;
                background-color: #fff;
                border-radius: 4px;
                text-align: center;
                padding: 10px;
                box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            }
        </style>
        <script>
            function process_verification(){                
                var email = $("#email").val();
                var verification_code = $("#verification-code").val();
                
                if(email == "") {
                    $("#message").html("Email harus diisi");
                    $("#message").removeClass("text-success");
                    $("#message").addClass("text-danger");

                    $(".alert").removeClass("alert-success");
                    $(".alert").addClass("alert-danger");
                    return false;
                }
                if(verification_code == "") {
                    $("#message").html("Kode verifikasi harus diisi");
                    $("#message").removeClass("text-success");
                    $("#message").addClass("text-danger");

                    $(".alert").removeClass("alert-success");
                    $(".alert").addClass("alert-danger");
                    return false;
                }
                
                $.ajax({
                    url: "<?= base_url('daftar/proses_verifikasi') ?>", 
                    type: 'POST', 
                    data: {
                        'email' : email, 
                        'verification_code' : verification_code
                    }, beforeSend: function (xhr) {
                        show_loader();
                    }, complete: function (jqXHR, textStatus ) {
                        hide_loader();
                    }, success: function (data, textStatus, jqXHR) {
                        var json;
                        var type_, response;                  

                        try{
                            json = $.parseJSON(data);
                            console.log(json);
                            type_ = json.type;
                            response = json.response;    

                            if(type_.trim() !== "ERROR"){ 
                                $("#message").html("Email telah berhasil diverifikasi.<br/>Mohon tunggu, anda sedang diarahkan ke halaman utama");                                
                                $("#message").removeClass("text-danger");
                                $("#message").addClass("text-success");
                                $(".alert").removeClass("alert-danger");
                                $(".alert").addClass("alert-success");
                                
                                window.location.href = "<?= base_url() ?>";
                            }else{
                                $("#message").html(response);
                                $("#message").removeClass("text-success");
                                $("#message").addClass("text-danger");
                                
                                $(".alert").removeClass("alert-success");
                                $(".alert").addClass("alert-danger");
                            }                           
                        }catch (e){
                            hide_loader();
                            $("#message").html("Aplikasi error");
                            $("#message").removeClass("text-success");
                            $("#message").addClass("text-danger");
                            $(".alert").removeClass("alert-success");
                            $(".alert").addClass("alert-danger");
                        }
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        $("#message").html("Aplikasi error #2");
                        $("#message").removeClass("text-success");
                        $("#message").addClass("text-danger");
                        $(".alert").removeClass("alert-success");
                        $(".alert").addClass("alert-danger");
                    }
                });
            }
        </script>
    </body>    
</html>