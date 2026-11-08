<!-- App Favicon -->
<link rel="shortcut icon" href="assets/images/favicon.ico">

<!-- Notification css (Toastr) -->
<link href="<?= base_url() ?>assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />

<!-- DataTables -->
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />

<!-- App CSS -->
<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>assets/css/core.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>assets/css/components.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

<script src="<?= base_url() ?>assets/js/modernizr.min.js"></script>

<style>

  html {
    background-color: #eee;
  }
  #wrapper > div.topbar > div.navbar.navbar-default{
    background-color: #fafafa;
  }
  #wrapper > div.topbar{
    box-shadow: 1px 1px 20px rgba(0,0,0,0.1);
  }  
  #wrapper > div.content-page > div{
    padding-top: 20px;
  }

  @media (max-width: 768px){     
    #wrapper > div.content-page > div{
      padding-top: 0px;
    } 
  }

  .user-box{
    border-bottom: 1px solid #f0f0f0;
  }

  .form-control{
    height: auto !important;
  }

  .form-group .control-label{
    text-align: left;
  }
</style>