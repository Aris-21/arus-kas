<?php
$user = get_session("user");
$user_level_name = $user["user_login_level_name"];
?>

<!-- Top Bar Start -->
<div class="topbar">

<!-- LOGO -->
<div class="topbar-left hidden-sm hidden-xs">
    <a href="index.html" class="logo"><span>Alur<span> Kas</span></span></a>
</div>

<!-- Button mobile view to collapse sidebar menu -->
<div class="navbar navbar-default" role="navigation">
    <div class="container">

        <!-- Page title -->
        <ul class="nav navbar-nav navbar-left">
            <li>
                <button class="button-menu-mobile open-left">
                    <i class="zmdi zmdi-menu"></i>
                </button>
            </li>
            <li>
                <h4 class="page-title" id="app-header-title"></h4>
            </li>
        </ul>       
    </div><!-- end container -->
</div><!-- end navbar -->
</div>
<!-- Top Bar End -->