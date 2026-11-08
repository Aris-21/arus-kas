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
                <h4><i class="fa fa-refresh"></i>&nbsp; Pindah buku</h4>
            </div>
            <!-- Main content -->
            <section class="content">
                <button class="btn btn-xs btn-primary" onclick="load_transfer_detail('0')">&nbsp;Tambah</button>
                
                <div class="box box-danger" style="margin-top: 10px">
                    <div class="box-body">
                        <div class="table-responsive" id="transfer-list-content">                            
                        </div>
                    </div>
                    <div class="box-footer">                        
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Modal Kategori Detail -->
        <div class="modal fade" style="overflow-y: auto" id="modal-transfer-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Pindah buku</h4>
                    </div>
                    <div id="modal-transfer-detail-body">
                        
                    </div>
                  </div>
            </div>
        </div>                        
        <?php view('templates/footer') ?>
        <script>           
            $(document).ready(function(){
                load_transfer_list();
            });
        </script>
    </body>
</html>