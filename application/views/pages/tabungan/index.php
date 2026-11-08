
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
      <link href="<?= base_url("assets/plugins/select2/dist/css/select2.css") ?>" rel="stylesheet" type="text/css">
      <link href="<?= base_url("assets/plugins/select2/dist/css/select2-bootstrap.css") ?>" rel="stylesheet" type="text/css">

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
                                <button type="button" class="btn btn-sm btn-primary" onclick="load_detail('')"><i class="fa fa-plus"></i>&nbsp; Tambah</button>            
                            </div>
                            <h3 class="panel-title">Tabungan</h3>                  
                        </div>

                        <div class="panel-body" id="table-content">                         
                            <div class="table-responsive mt-3">
                                <table class="table table-striped table-bordered table-dashboard-two mg-b-0" id="datatable">
                                    <thead>
                                        <tr>
                                          <th>#</th>
                                          <th></th>
                                          <th>Nama</th>                          
                                          <th>Keterangan</th>
                                          <th>Saldo</th>
                                          <th>Terakhir diubah</th>
                                          <th>Diubah oleh</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th></th>                                            
                                          <th></th>                                            
                                          <th><input type="text" style="width: 100px" class="form-control search-input-text input-sm" data-column="2" placeholder="Cari ..." /></th>
                                          <th><input type="text" style="width: 140px" class="form-control search-input-text input-sm" data-column="3" placeholder="Cari ..." /></th>
                                          <th></th>
                                          <th><input type="text" style="width: 200px" class="form-control search-input-text input-sm" data-column="6" placeholder="Cari ..." /></th>
                                          <th></th>
                                        </tr>
                                    </tfoot>

                                    <tbody></tbody>
                                </table>
                            </div><!-- table-responsive -->                                                       
                        </div> <!-- panel body -->
                    </div> <!-- panel -->

                </div> <!-- col -->
            </div> <!-- row -->
          </div> <!-- container -->
        </div> <!-- content -->
      </div> <!-- content-page -->

      <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h3 class="modal-title"><span id="modal-title"></span> Tabungan</h3>
            </div>

            <div class="modal-body" id="modal-detail-body">                  
            </div>
          </div>
        </div><!-- modal-dialog -->
      </div><!-- modal -->

      <?php view("templates/footer") ?>
    </div><!-- az-content -->

    <?php view("templates/script") ?>
    <script src="<?= base_url("assets/plugins/select2/dist/js/select2.min.js") ?>" type="text/javascript"></script>

    <script>                
      var table;  
      $(document).ready(function (){
        $("#app-header-title").html("Tabungan");
        
        init_datatable();

        // column search aktif
        $('.search-input-text').unbind();
        $('.search-input-text').bind( 'keyup', function (e) {
            var i = $(this).attr('data-column');   // getting column index
            var v = $(this).val();                 // getting search input value
            if(e.keyCode == 13 || v == ""){
              table.columns(i).search(v).draw();
            }
        });

        $('.search-input-select').on( 'change', function () {
            var i = $(this).attr('data-column');   // getting column index
            var v = $(this).val();                 // getting search input value
            table.columns(i).search(v).draw();
        });

        $("#datatable_filter input").unbind();
        $("#datatable_filter input").bind("keyup", function (e){
          var v = this.value;
          if (e.keyCode == 13 || v == "") {
            table.search( v ).draw();
          }
        }); 
      });
      
      function init_datatable(){
        if(! $.fn.DataTable.isDataTable("#datatable")){
            table = $("#datatable").DataTable({ 

              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode. 


              "oLanguage": {
                "sSearch": "Cari",
                "sLengthMenu": "Tampilkan _MENU_ baris",
                "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ baris",
              },

              // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": "<?php echo site_url('tabungan/ajax_list')?>",
                  "type": "GET",
                  beforeSend: function (xhr) {   
                      $("#loader").show();
                  },
                  complete: function (jqXHR, textStatus) {                
                    $("#loader").hide();
                  },
                  statusCode: status_code,
              },

              // order
  //            "ordering": true,
              "order": [[2, "asc"]],
              "aLengthMenu": [[10,25, 50, 100, 250, 500, -1], [10,25, 50, 100, 250, 500, "All"]],

              //Set column definition initialisation properties.
              "columnDefs": [
                { 
                    "targets": 0,   // column-1
                    "orderable": false, //set not orderable,
                    "responsivePriority": 1,
                },
                { 
                    "targets": 4,   // column-6
                    "orderable": false, //set not orderable,
                },
                { 
                    "targets": 6,   // column-8
                    "orderable": false, //set not orderable,
                },
                { 
                    "targets": 1,   // column-2                      
                    "orderable": false, //set not orderable,
  //                  "responsivePriority": 2,
                    "data": null,
                    render: function (data, type, row){
                      var html = "<a href=\"javascript:void(0);\" onclick=\"load_detail('" + data.hash_id + "')\"> <i class='fa fa-edit'></i></a>";
                      return html;
                    }
                },
              ],
              "columns": [
                {"data": "no"},                 // col-0                  
                {"data": null},                 // col-1
                {"data": "nama"},               // col-2                
                {"data": "keterangan"},         // col-3
                {"data": "saldo_formatted"},    // col-4
                {"data": "modified"},           // col-5
                {"data": "modifier_user_name"}, // col-6
              ]
          });
        }else{
          table.draw();
        }
      }

      function load_list(){
        init_datatable();
      }

      function load_detail(hash_id){
        ajax_get(
          "<?= base_url('tabungan/ajax_detail') ?>/" + hash_id,
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
          "<?= base_url("tabungan/ajax_save") ?>",
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

      function confirm_delete(hash_id){     
        var confirmed = confirm("Yakin ingin menghapus tabungan ini ?");
        if(!confirmed) return false;
        
        ajax_get(
          "<?= base_url("tabungan/ajax_delete") ?>/" + hash_id,
          {}, 
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
    </script>
  </body>
</html>