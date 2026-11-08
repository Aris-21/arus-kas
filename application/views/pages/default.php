<!DOCTYPE html>
<html>
    <head>        
        <?php view('templates/meta') ?>
        <?php view('templates/style') ?>
        <?php view('templates/script') ?>
    </head>
    <body class="hold-transition <?= APP_SKIN ?> sidebar-mini">     
        <?php view('templates/header') ?>
        <?php view('templates/sidebar') ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <h1><?= APP_CLIENT_NAME ?></h1>
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h1 class="box-title">Judul Table</h1>
                        <div class="box-tools">
                            
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table-berita">
                                <thead>
                                    
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        
                    </div>
                </div>
            </section>
        </div>
                
        <script>
            
        </script>
        <?php view('templates/footer') ?>
    </body>
</html>