<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/detect.js"></script>
<script src="<?= base_url() ?>assets/js/fastclick.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.blockUI.js"></script>
<script src="<?= base_url() ?>assets/js/waves.js"></script>
<script src="<?= base_url() ?>assets/js/wow.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.scrollTo.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url("assets/plugins/jquery-knob/jquery.knob.js") ?>"></script>

<!-- App js -->
<script src="<?= base_url() ?>assets/js/jquery.core.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.app.js"></script>

<!-- Toastr js -->
<script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js"></script>


<script>
  
    var status_code = {
                200: function() { },
                201: function(xhr) {  },
                400: function(xhr) {
                    try {                        
                        var response_text = JSON.parse(xhr.responseText);
                        show_toast(xhr.statusText, response_text.message, "error");
                    } catch (error) {
                        show_toast("Error","Application Response Error", "error");
                    }
                },
                401: function(xhr) {
                    try {                 
                        var response_text = JSON.parse(xhr.responseText);
                        show_toast(xhr.statusText, response_text.message, "error");
                    } catch (error) {
                        show_toast("Error","Application Response Error", "error");
                    }

                },
                402: function(xhr) { console.log(text + ", " + status + ", ") },
                403: function(xhr) { 
                    try {                 
                        var response_text = JSON.parse(xhr.responseText);
                        show_toast("Gagal", response_text.message, "warning");
                    } catch (error) {
                        show_toast("Error","Application Response Error", "error");
                    }
                },
                404: function(xhr) { console.log(xhr) },
                405: function(xhr) { console.log(text + ", " + status + ", ") },
                500: function(xhr) {                     
                    try {                                                
                        show_toast(xhr.statusText, "Server Response Error", "error");
                    } catch (error) {
                        show_toast("Error","Application Response Error", "error");
                    }
                }
              }
    function ajax_get_loader_text(url, data, target, text, resp_){
        $.ajax({
            url: url, 
            type: "GET",
            data: data, 
            beforeSend: function (xhr) {   
                $(target).html(text);
            },
            complete: function (jqXHR, textStatus) {                
            },
            statusCode: status_code,
            success: function(resp, status) {
                resp_(resp);
            },
            error: function (jqXHR, textStatus, errorThrown) {  
                $("#loader").hide();              
            }
        });
    }
    function ajax_get(url, data, resp_){
        $.ajax({
            url: url, 
            type: "GET",
            data: data, 
            beforeSend: function (xhr) {   
                $("#loader").show();
            },
            complete: function (jqXHR, textStatus) {
                $("#loader").hide();
            },
            statusCode: status_code,
            success: function(resp, status) {
                resp_(resp);
            },
            error: function (jqXHR, textStatus, errorThrown) {  
                $("#loader").hide();              
            }
        });
    }

    function ajax_post(url, data, resp_){
        var ajax = $.ajax({
            url: url, 
            type: "POST",
            data: data, 
            beforeSend: function (xhr) {   
                $("#loader").show();
            },
            complete: function (jqXHR, textStatus) {
                $("#loader").hide();
            },
            statusCode: status_code,
            success: function(resp, status) {
                resp_(resp);
            },
            error: function (jqXHR, textStatus, errorThrown) {                
                $("#loader").hide();
            }
        });        
    }

    function ajax_post_file(url, data, resp_){
        var ajax = $.ajax({
            url: url, 
            type: "POST",
            enctype: 'multipart/form-data',
            data: data, 
            processData: false,  // Important!
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend: function (xhr) {   
                $("#loader").show();
            },
            complete: function (jqXHR, textStatus) {
                $("#loader").hide();
            },
            statusCode: status_code,
            success: function(resp, status) {
                resp_(resp);
            },
            error: function (jqXHR, textStatus, errorThrown) {                
                $("#loader").hide();
            }
        });        
    }

    function show_toast(title, message, type){
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr[type](message, title);
    }
</script>