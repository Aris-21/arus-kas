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
        <!--<link href="https://fonts.googleapis.com/css?family=Italianno" rel="stylesheet">-->
        <link href="https://fonts.googleapis.com/css?family=Mr+De+Haviland" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Marvel" rel="stylesheet">

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
                        <form method="post" action="<?= base_url('daftar/proses_daftar') ?>">
                            <div class="login-box">
                                <div class="login-box-header">
                                    <h3 style="text-align: center"><i class="fa fa-user"></i>&nbsp; Daftar</h3>
                                </div>
                                <div class="login-box-body">
                                    <?php
                                    if(isset($_SESSION[SESSION_PREFIX . "ADMIN_ERROR"])){                                                        
                                        $error = $_SESSION[SESSION_PREFIX . "ADMIN_ERROR"];
                                        $response = $error['response'];
                                        $type = $error['type'];
                                    ?>
                                    <div style="padding-bottom: 20px;width:100%;text-align: center">
                                        <span style="font-size: 16px;font-weight: bold" class="text-danger"><?= $response ?></span>
                                    </div>
                                    <?php
                                    unset($_SESSION[SESSION_PREFIX . "ADMIN_ERROR"]);
                                    }
                                    
                                    // set back form value if isset
                                    $email = get_session("email");
                                    $full_name = get_session("full_name");
                                    $username = get_session("username");
                                    ?>
                                    <input type="text" name="email" class="form-input" placeholder="Email" required value="<?= $email ?>"/>
                                    <input type="text" name="full_name" class="form-input" placeholder="Nama lengkap" required value="<?= $full_name ?>"/>
                                         
                                    <hr/>                                    
                                    <input type="password" name="password" class="form-input" placeholder="Password" required/>
                                    <input type="password" name="retype_password" class="form-input" placeholder="Ulang Password" required/>

                                    <hr/>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <span style="line-height: 40px;padding-left: 20px;font-size: 14px">Kode keamanan</span>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <img style="width: 100%; height: 40px;border-radius: 4px; border: 1px solid #ccc; background-color: rgb(250, 250, 250)" src="<?= base_url('captcha') ?>" />
                                        </div>
                                    </div>
                                    <input type="text" name="captcha" class="form-input" placeholder="Masukkan kode keamanan" style="margin-top: 10px;margin-bottom: 20px" required/>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button type="submit" class="btn-login btn-block">Daftar <i class="fa fa-arrow-right" style="margin-left: 10px"></i></button>                                
                                        </div>
                                    </div>
                                </div>
                                <div class="login-box-footer">                        
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="sign-up">
                                                        Sudah punya akun ? <a href="<?= base_url('signin') ?>" class="text-primary">Masuk sekarang</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    </body>
</html>