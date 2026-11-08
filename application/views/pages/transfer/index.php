<!DOCTYPE html>
<html lang="en">

<head>

    <?php view("templates/meta") ?>
    <?php view("templates/style") ?>

    <link
        href="<?= base_url("assets/plugins/select2/dist/css/select2.css") ?>"
        rel="stylesheet"
        type="text/css"
    >

    <link
        href="<?= base_url("assets/plugins/select2/dist/css/select2-bootstrap.css") ?>"
        rel="stylesheet"
        type="text/css"
    >

    <link
        href="<?= base_url("assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css") ?>"
        rel="stylesheet"
    >


    <!-- =========================================================
         MODERN TRANSFER STYLE
         HANYA TAMPILAN - LOGIC TETAP
    ========================================================== -->

    <style>

        /*
        |--------------------------------------------------------------------------
        | PAGE
        |--------------------------------------------------------------------------
        */

        body {
            background: #f4f7fb;
        }

        .transfer-page {
            padding-top: 5px;
            padding-bottom: 30px;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGE HEADER
        |--------------------------------------------------------------------------
        */

        .transfer-page-header {
            margin-bottom: 22px;
        }

        .transfer-page-title {
            margin: 0;
            color: #172554;
            font-size: 24px;
            font-weight: 700;
        }

        .transfer-page-subtitle {
            color: #7b8794;
            font-size: 13px;
            margin-top: 6px;
        }


        /*
        |--------------------------------------------------------------------------
        | INFO CARDS
        |--------------------------------------------------------------------------
        */

        .transfer-info-card {

            position: relative;

            background: #ffffff;

            border: 0;

            border-radius: 14px;

            padding: 22px;

            min-height: 125px;

            margin-bottom: 20px;

            box-shadow:
                0 4px 18px
                rgba(15, 23, 42, 0.07);

            overflow: hidden;

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }


        .transfer-info-card:hover {

            transform: translateY(-2px);

            box-shadow:
                0 8px 25px
                rgba(15, 23, 42, 0.10);
        }


        .transfer-info-card:before {

            content: "";

            position: absolute;

            top: 0;

            left: 0;

            right: 0;

            height: 4px;
        }


        .transfer-info-card.primary:before {
            background: #2563eb;
        }


        .transfer-info-card.success:before {
            background: #0f766e;
        }


        .transfer-info-card.info:before {
            background: #7c3aed;
        }


        /*
        |--------------------------------------------------------------------------
        | CARD ICON
        |--------------------------------------------------------------------------
        */

        .transfer-info-icon {

            width: 48px;

            height: 48px;

            border-radius: 12px;

            display: inline-block;

            text-align: center;

            line-height: 48px;

            font-size: 20px;

            float: left;

            margin-right: 15px;
        }


        .transfer-info-icon.primary {

            background: #eff6ff;

            color: #2563eb;
        }


        .transfer-info-icon.success {

            background: #f0fdfa;

            color: #0f766e;
        }


        .transfer-info-icon.info {

            background: #f5f3ff;

            color: #7c3aed;
        }


        /*
        |--------------------------------------------------------------------------
        | CARD CONTENT
        |--------------------------------------------------------------------------
        */

        .transfer-info-content {
            overflow: hidden;
        }


        .transfer-info-label {

            color: #64748b;

            font-size: 12px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: .4px;

            margin-bottom: 7px;
        }


        .transfer-info-value {

            color: #172554;

            font-size: 17px;

            font-weight: 700;

            line-height: 1.3;
        }


        .transfer-info-description {

            color: #94a3b8;

            font-size: 11px;

            margin-top: 6px;
        }


        /*
        |--------------------------------------------------------------------------
        | MAIN PANEL
        |--------------------------------------------------------------------------
        */

        .modern-panel {

            background: #ffffff;

            border: 0 !important;

            border-radius: 14px;

            overflow: hidden;

            box-shadow:
                0 4px 18px
                rgba(15, 23, 42, 0.07);
        }


        .modern-panel-header {

            padding: 18px 20px;

            border-bottom: 1px solid #edf2f7;

            background: #ffffff;
        }


        .modern-panel-title {

            color: #172554;

            font-size: 17px;

            font-weight: 700;

            margin: 0;
        }


        .modern-panel-subtitle {

            color: #94a3b8;

            font-size: 12px;

            margin-top: 5px;
        }


        .modern-panel-body {

            padding: 20px;
        }


        /*
        |--------------------------------------------------------------------------
        | ADD BUTTON
        |--------------------------------------------------------------------------
        */

        .btn-modern {

            border: 0;

            border-radius: 7px;

            font-size: 12px;

            font-weight: 600;

            padding: 8px 14px;

            transition: all .2s ease;
        }


        .btn-modern-primary {

            background: #2563eb;

            color: #ffffff;
        }


        .btn-modern-primary:hover,
        .btn-modern-primary:focus {

            background: #1d4ed8;

            color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | ACTION BUTTONS
        |--------------------------------------------------------------------------
        */

        .transfer-action-group {

            display: inline-flex;

            white-space: nowrap;
        }


        .transfer-action-btn {

            width: 30px;

            height: 30px;

            border: 0;

            border-radius: 6px;

            margin-right: 4px;

            text-align: center;

            line-height: 30px;

            padding: 0;

            cursor: pointer;

            transition: all .15s ease;
        }


        /*
        | VIEW
        */

        .transfer-action-view {

            background: #e0f2fe;

            color: #0369a1;
        }


        .transfer-action-view:hover {

            background: #0369a1;

            color: #ffffff;
        }


        /*
        | EDIT
        */

        .transfer-action-edit {

            background: #fef3c7;

            color: #b45309;
        }


        .transfer-action-edit:hover {

            background: #d97706;

            color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | DATATABLE
        |--------------------------------------------------------------------------
        */

        #datatable {

            border-collapse: separate !important;

            border-spacing: 0;

            width: 100% !important;
        }


        #datatable thead th {

            background: #172554;

            color: #ffffff;

            border-color: #172554;

            font-size: 12px;

            font-weight: 600;

            vertical-align: middle;

            padding: 11px 8px;
        }


        #datatable tbody td {

            color: #475569;

            font-size: 12px;

            vertical-align: middle;

            padding: 10px 8px;

            border-color: #edf2f7;
        }


        #datatable tbody tr:hover td {

            background: #f8fafc;
        }


        #datatable tfoot th {

            background: #f8fafc;

            border-color: #e2e8f0;

            padding: 7px 5px;
        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH INPUT
        |--------------------------------------------------------------------------
        */

        .search-input-text {

            border: 1px solid #dbe3ec !important;

            border-radius: 6px !important;

            box-shadow: none !important;

            font-size: 11px;

            width: 100% !important;
        }


        .search-input-text:focus {

            border-color: #2563eb !important;

            box-shadow: none !important;
        }


        /*
        |--------------------------------------------------------------------------
        | DATATABLE CONTROL
        |--------------------------------------------------------------------------
        */

        .dataTables_wrapper
        .dataTables_filter input {

            border: 1px solid #dbe3ec;

            border-radius: 6px;

            padding: 6px 10px;

            outline: none;
        }


        .dataTables_wrapper
        .dataTables_length select {

            border: 1px solid #dbe3ec;

            border-radius: 6px;

            padding: 4px;
        }


        .pagination > .active > a,
        .pagination > .active > span {

            background-color: #2563eb;

            border-color: #2563eb;
        }


        /*
        |--------------------------------------------------------------------------
        | MODAL
        |--------------------------------------------------------------------------
        */

        .modern-modal
        .modal-content {

            border: 0;

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 15px 45px
                rgba(15, 23, 42, .18);
        }


        .modern-modal
        .modal-header {

            background: #172554;

            color: #ffffff;

            border: 0;

            padding: 16px 20px;
        }


        .modern-modal
        .modal-title {

            color: #ffffff;

            font-size: 17px;

            font-weight: 600;
        }


        .modern-modal
        .modal-header
        .close {

            color: #ffffff;

            opacity: .9;

            text-shadow: none;
        }


        .modern-modal
        .modal-body {

            padding: 22px;
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSFER FLOW
        |--------------------------------------------------------------------------
        */

        .transfer-flow {

            background: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            padding: 16px 20px;

            margin-bottom: 20px;
        }


        .transfer-flow-table {

            width: 100%;

            border: 0;

            margin: 0;
        }


        .transfer-flow-table td {

            border: 0;

            vertical-align: middle;

            padding: 4px 8px;
        }


        .transfer-flow-icon {

            width: 42px;

            height: 42px;

            border-radius: 50%;

            background: #eff6ff;

            color: #2563eb;

            display: inline-block;

            line-height: 42px;

            text-align: center;

            font-size: 18px;
        }


        .transfer-flow-arrow {

            color: #94a3b8;

            font-size: 20px;

            text-align: center;
        }


        .transfer-flow-title {

            font-size: 12px;

            font-weight: 700;

            color: #334155;
        }


        .transfer-flow-text {

            font-size: 11px;

            color: #94a3b8;

            margin-top: 3px;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media(max-width: 767px){

            .transfer-page-title {

                font-size: 20px;
            }


            .modern-panel-header
            .pull-right {

                float: none !important;

                margin-bottom: 12px;
            }


            .btn-modern {

                width: 100%;

                margin-bottom: 8px;
            }


            .transfer-info-value {

                font-size: 15px;
            }

        }

    </style>

</head>



<body class="fixed-left">


<!-- =============================================================
     WRAPPER
============================================================== -->

<div id="wrapper">


    <?php view("templates/header") ?>

    <?php view("templates/sidebar") ?>



    <!-- =========================================================
         CONTENT
    ========================================================== -->

    <div class="content-page">


        <div class="content">


            <div class="container transfer-page">



                <!-- =================================================
                     PAGE HEADER
                ================================================== -->

                <div class="transfer-page-header">


                    <h2 class="transfer-page-title">

                        Pindah Buku

                    </h2>


                    <div class="transfer-page-subtitle">

                        Kelola transfer dana antar tabungan
                        secara cepat dan terstruktur.

                    </div>


                </div>



                <!-- =================================================
                     INFO CARDS
                ================================================== -->

                <div class="row">


                    <!-- TRANSFER -->

                    <div class="col-md-4 col-sm-6">


                        <div class="transfer-info-card primary">


                            <div class="transfer-info-icon primary">

                                <i class="fa fa-exchange"></i>

                            </div>


                            <div class="transfer-info-content">


                                <div class="transfer-info-label">

                                    Pindah Buku

                                </div>


                                <div class="transfer-info-value">

                                    Transfer Antar Tabungan

                                </div>


                                <div class="transfer-info-description">

                                    Pemindahan saldo dari satu
                                    tabungan ke tabungan lainnya.

                                </div>


                            </div>


                        </div>


                    </div>



                    <!-- SUMBER -->

                    <div class="col-md-4 col-sm-6">


                        <div class="transfer-info-card success">


                            <div class="transfer-info-icon success">

                                <i class="fa fa-bank"></i>

                            </div>


                            <div class="transfer-info-content">


                                <div class="transfer-info-label">

                                    Tabungan Sumber

                                </div>


                                <div class="transfer-info-value">

                                    Sumber Dana

                                </div>


                                <div class="transfer-info-description">

                                    Dana akan dikurangi dari
                                    tabungan yang dipilih.

                                </div>


                            </div>


                        </div>


                    </div>



                    <!-- TUJUAN -->

                    <div class="col-md-4 col-sm-6">


                        <div class="transfer-info-card info">


                            <div class="transfer-info-icon info">

                                <i class="fa fa-sign-in"></i>

                            </div>


                            <div class="transfer-info-content">


                                <div class="transfer-info-label">

                                    Tabungan Tujuan

                                </div>


                                <div class="transfer-info-value">

                                    Tujuan Dana

                                </div>


                                <div class="transfer-info-description">

                                    Dana akan ditambahkan ke
                                    tabungan tujuan.

                                </div>


                            </div>


                        </div>


                    </div>


                </div>



                <!-- =================================================
                     TRANSFER FLOW
                ================================================== -->

                <div class="transfer-flow">


                    <table class="transfer-flow-table">

                        <tr>


                            <!-- SOURCE -->

                            <td width="8%" class="text-center">

                                <span class="transfer-flow-icon">

                                    <i class="fa fa-bank"></i>

                                </span>

                            </td>


                            <td width="28%">

                                <div class="transfer-flow-title">

                                    Tabungan Sumber

                                </div>

                                <div class="transfer-flow-text">

                                    Saldo dikurangi

                                </div>

                            </td>



                            <!-- ARROW -->

                            <td
                                width="10%"
                                class="transfer-flow-arrow"
                            >

                                <i class="fa fa-long-arrow-right"></i>

                            </td>



                            <!-- TRANSFER -->

                            <td
                                width="8%"
                                class="text-center"
                            >

                                <span class="transfer-flow-icon">

                                    <i class="fa fa-exchange"></i>

                                </span>

                            </td>


                            <td width="18%">

                                <div class="transfer-flow-title">

                                    Transfer

                                </div>

                                <div class="transfer-flow-text">

                                    Pindah buku

                                </div>

                            </td>



                            <!-- ARROW -->

                            <td
                                width="10%"
                                class="transfer-flow-arrow"
                            >

                                <i class="fa fa-long-arrow-right"></i>

                            </td>



                            <!-- DESTINATION -->

                            <td
                                width="8%"
                                class="text-center"
                            >

                                <span class="transfer-flow-icon">

                                    <i class="fa fa-bank"></i>

                                </span>

                            </td>


                            <td width="18%">

                                <div class="transfer-flow-title">

                                    Tabungan Tujuan

                                </div>

                                <div class="transfer-flow-text">

                                    Saldo ditambahkan

                                </div>

                            </td>


                        </tr>

                    </table>


                </div>



                <!-- =================================================
                     MAIN PANEL
                ================================================== -->

                <div class="row">


                    <div class="col-md-12">


                        <div class="modern-panel">



                            <!-- =========================================
                                 PANEL HEADER
                            ========================================== -->

                            <div class="modern-panel-header">


                                <div class="pull-right">


                                    <button
                                        type="button"
                                        class="
                                            btn
                                            btn-modern
                                            btn-modern-primary
                                        "
                                        onclick="load_detail('')"
                                    >

                                        <i class="fa fa-plus"></i>

                                        &nbsp;

                                        Tambah Transfer

                                    </button>


                                </div>



                                <h3 class="modern-panel-title">

                                    Data Pindah Buku

                                </h3>


                                <div class="modern-panel-subtitle">

                                    Daftar transaksi transfer
                                    antar tabungan.

                                </div>


                                <div class="clearfix"></div>


                            </div>



                            <!-- =========================================
                                 PANEL BODY
                            ========================================== -->

                            <div
                                class="modern-panel-body"
                                id="table-content"
                            >


                                <div class="table-responsive">


                                    <table
                                        class="
                                            table
                                            table-bordered
                                        "
                                        id="datatable"
                                    >


                                        <!-- =============================
                                             HEADER
                                        ============================== -->

                                        <thead>

                                        <tr>


                                            <th style="width:45px;">

                                                #

                                            </th>


                                            <th style="width:85px;">

                                                Aksi

                                            </th>


                                            <th>

                                                No. Kas

                                            </th>


                                            <th>

                                                Tanggal

                                            </th>


                                            <th>

                                                Tabungan Sumber

                                            </th>


                                            <th>

                                                Tabungan Tujuan

                                            </th>


                                            <th>

                                                Jumlah

                                            </th>


                                            <th>

                                                Keterangan

                                            </th>


                                            <th>

                                                Terakhir Diubah

                                            </th>


                                            <th>

                                                Diubah Oleh

                                            </th>


                                        </tr>

                                        </thead>



                                        <!-- =============================
                                             FILTER
                                        ============================== -->

                                        <tfoot>

                                        <tr>


                                            <th></th>


                                            <th></th>


                                            <th>

                                                <input
                                                    type="text"
                                                    class="
                                                        form-control
                                                        search-input-text
                                                        input-sm
                                                    "
                                                    data-column="2"
                                                    placeholder="Cari..."
                                                >

                                            </th>


                                            <th>

                                                <input
                                                    type="text"
                                                    class="
                                                        form-control
                                                        search-input-text
                                                        input-sm
                                                    "
                                                    data-column="3"
                                                    placeholder="Tanggal..."
                                                >

                                            </th>


                                            <th>

                                                <input
                                                    type="text"
                                                    class="
                                                        form-control
                                                        search-input-text
                                                        input-sm
                                                    "
                                                    data-column="4"
                                                    placeholder="Cari..."
                                                >

                                            </th>


                                            <th>

                                                <input
                                                    type="text"
                                                    class="
                                                        form-control
                                                        search-input-text
                                                        input-sm
                                                    "
                                                    data-column="5"
                                                    placeholder="Cari..."
                                                >

                                            </th>


                                            <th>

                                                <input
                                                    type="text"
                                                    class="
                                                        form-control
                                                        search-input-text
                                                        input-sm
                                                    "
                                                    data-column="6"
                                                    placeholder="Cari..."
                                                >

                                            </th>


                                            <th>

                                                <input
                                                    type="text"
                                                    class="
                                                        form-control
                                                        search-input-text
                                                        input-sm
                                                    "
                                                    data-column="7"
                                                    placeholder="Cari..."
                                                >

                                            </th>


                                            <th></th>


                                            <th>

                                                <input
                                                    type="text"
                                                    class="
                                                        form-control
                                                        search-input-text
                                                        input-sm
                                                    "
                                                    data-column="9"
                                                    placeholder="Cari..."
                                                >

                                            </th>


                                        </tr>

                                        </tfoot>



                                        <tbody></tbody>


                                    </table>


                                </div>


                            </div>


                        </div>


                    </div>


                </div>


            </div>


        </div>


    </div>



    <!-- =========================================================
         MODAL DETAIL
    ========================================================== -->

    <div
        class="modal fade modern-modal"
        id="modal-detail"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
    >


        <div class="modal-dialog">


            <div class="modal-content">


                <div class="modal-header">


                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >

                        <span aria-hidden="true">

                            &times;

                        </span>

                    </button>


                    <h3 class="modal-title">

                        <i class="fa fa-exchange"></i>

                        &nbsp;

                        <span id="modal-title"></span>

                        Pindah Buku (Transfer)

                    </h3>


                </div>


                <div
                    class="modal-body"
                    id="modal-detail-body"
                >
                </div>


            </div>


        </div>


    </div>



    <!-- =========================================================
         MODAL VIEW
    ========================================================== -->

    <div
        class="modal fade modern-modal"
        id="modal-view"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
    >


        <div class="modal-dialog">


            <div class="modal-content">


                <div class="modal-header">


                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >

                        <span aria-hidden="true">

                            &times;

                        </span>

                    </button>


                    <h3 class="modal-title">

                        <i class="fa fa-eye"></i>

                        &nbsp;

                        Detail Pindah Buku

                    </h3>


                </div>


                <div
                    class="modal-body"
                    id="modal-view-body"
                >
                </div>


            </div>


        </div>


    </div>



    <?php view("templates/footer") ?>


</div>



<!-- =============================================================
     SCRIPT
============================================================== -->

<?php view("templates/script") ?>


<script
    src="<?= base_url("assets/plugins/select2/dist/js/select2.min.js") ?>"
    type="text/javascript"
></script>


<script
    src="<?= base_url("assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js") ?>"
></script>



<script>


    /*
    |--------------------------------------------------------------------------
    | GLOBAL DATATABLE
    |--------------------------------------------------------------------------
    */

    var table;



    /*
    |--------------------------------------------------------------------------
    | DOCUMENT READY
    |--------------------------------------------------------------------------
    */

    $(document).ready(function(){


        $("#app-header-title").html(
            "Pindah Buku (Transfer)"
        );


        /*
        |--------------------------------------------------------------------------
        | INIT TABLE
        |--------------------------------------------------------------------------
        */

        init_datatable();



        /*
        |--------------------------------------------------------------------------
        | COLUMN SEARCH
        |--------------------------------------------------------------------------
        */

        $('.search-input-text').unbind();


        $('.search-input-text').bind(
            'keyup',
            function(e){


                var i =
                    $(this).attr(
                        'data-column'
                    );


                var v =
                    $(this).val();


                if(
                    e.keyCode == 13 ||
                    v == ""
                ){


                    table
                        .columns(i)
                        .search(v)
                        .draw();

                }


            }
        );



        /*
        |--------------------------------------------------------------------------
        | SELECT SEARCH
        |--------------------------------------------------------------------------
        */

        $('.search-input-select').on(
            'change',
            function(){


                var i =
                    $(this).attr(
                        'data-column'
                    );


                var v =
                    $(this).val();


                table
                    .columns(i)
                    .search(v)
                    .draw();


            }
        );



        /*
        |--------------------------------------------------------------------------
        | GLOBAL SEARCH
        |--------------------------------------------------------------------------
        */

        $("#datatable_filter input")
            .unbind();


        $("#datatable_filter input")
            .bind(
                "keyup",
                function(e){


                    var v =
                        this.value;


                    if(
                        e.keyCode == 13 ||
                        v == ""
                    ){


                        table
                            .search(v)
                            .draw();

                    }


                }
            );


    });



    /*
    |--------------------------------------------------------------------------
    | INIT DATATABLE
    |--------------------------------------------------------------------------
    */

    function init_datatable(){


        if(
            !$.fn.DataTable.isDataTable(
                "#datatable"
            )
        ){


            table =
                $("#datatable")
                .DataTable({


                    /*
                    |--------------------------------------------------------------------------
                    | SERVER SIDE
                    |--------------------------------------------------------------------------
                    */

                    "processing": true,

                    "serverSide": true,



                    /*
                    |--------------------------------------------------------------------------
                    | LANGUAGE
                    |--------------------------------------------------------------------------
                    */

                    "oLanguage": {


                        "sSearch":
                            "Cari",


                        "sLengthMenu":
                            "Tampilkan _MENU_ baris",


                        "sInfo":
                            "Menampilkan _START_ s/d _END_ dari _TOTAL_ baris",


                        "sInfoEmpty":
                            "Tidak ada data",


                        "sZeroRecords":
                            "Data tidak ditemukan",


                        "sProcessing":
                            "Memuat data..."


                    },



                    /*
                    |--------------------------------------------------------------------------
                    | AJAX
                    |--------------------------------------------------------------------------
                    |
                    | ENDPOINT ASLI TIDAK DIUBAH
                    |
                    */

                    "ajax": {


                        "url":
                            "<?= site_url('transfer/ajax_list') ?>",


                        "type":
                            "GET",


                        beforeSend:
                            function(xhr){


                                $("#loader")
                                    .show();


                            },


                        complete:
                            function(
                                jqXHR,
                                textStatus
                            ){


                                $("#loader")
                                    .hide();


                            },


                        statusCode:
                            status_code


                    },



                    /*
                    |--------------------------------------------------------------------------
                    | ORDER
                    |--------------------------------------------------------------------------
                    */

                    "order": [

                        [2, "desc"]

                    ],



                    /*
                    |--------------------------------------------------------------------------
                    | LENGTH
                    |--------------------------------------------------------------------------
                    */

                    "aLengthMenu": [

                        [
                            10,
                            25,
                            50,
                            100,
                            250,
                            500,
                            -1
                        ],

                        [
                            10,
                            25,
                            50,
                            100,
                            250,
                            500,
                            "Semua"
                        ]

                    ],



                    /*
                    |--------------------------------------------------------------------------
                    | COLUMN DEFINITIONS
                    |--------------------------------------------------------------------------
                    */

                    "columnDefs": [


                        /*
                        |--------------------------------------------------------------------------
                        | NUMBER
                        |--------------------------------------------------------------------------
                        */

                        {

                            "targets": 0,

                            "orderable": false,

                            "responsivePriority": 1

                        },



                        /*
                        |--------------------------------------------------------------------------
                        | ACTION
                        |--------------------------------------------------------------------------
                        |
                        | FUNGSI TETAP:
                        |
                        | - Edit
                        | - Lihat
                        |
                        | Hanya tampilannya yang diubah.
                        |
                        */

                        {

                            "targets": 1,

                            "orderable": false,

                            "data": null,


                            render:
                                function(
                                    data,
                                    type,
                                    row
                                ){


                                    var html = [];


                                    html.push(

                                        "<div " +

                                        "class='" +
                                        "transfer-action-group" +
                                        "'>"

                                    );



                                    /*
                                    |--------------------------------------------------------------------------
                                    | VIEW
                                    |--------------------------------------------------------------------------
                                    */

                                    html.push(

                                        "<button " +

                                        "type='button' " +

                                        "class='" +
                                        "transfer-action-btn " +
                                        "transfer-action-view" +
                                        "' " +

                                        "title='Lihat' " +

                                        "onclick=\"" +
                                        "load_view('" +
                                        data.hash_id +
                                        "')" +
                                        "\">" +

                                        "<i class='" +
                                        "fa fa-eye" +
                                        "'></i>" +

                                        "</button>"

                                    );



                                    /*
                                    |--------------------------------------------------------------------------
                                    | EDIT
                                    |--------------------------------------------------------------------------
                                    */

                                    html.push(

                                        "<button " +

                                        "type='button' " +

                                        "class='" +
                                        "transfer-action-btn " +
                                        "transfer-action-edit" +
                                        "' " +

                                        "title='Edit' " +

                                        "onclick=\"" +
                                        "load_detail('" +
                                        data.hash_id +
                                        "')" +
                                        "\">" +

                                        "<i class='" +
                                        "fa fa-edit" +
                                        "'></i>" +

                                        "</button>"

                                    );



                                    html.push(

                                        "</div>"

                                    );


                                    return html.join("");

                                }

                        }

                    ],



                    /*
                    |--------------------------------------------------------------------------
                    | COLUMNS
                    |--------------------------------------------------------------------------
                    |
                    | STRUKTUR ASLI DIPERTAHANKAN
                    |
                    */

                    "columns": [


                        {
                            "data": "no"
                        },


                        {
                            "data": null
                        },


                        {
                            "data":
                                "no_transfer_number_formatted"
                        },


                        {
                            "data":
                                "tanggal"
                        },


                        {
                            "data":
                                "tabungan_sumber_nama"
                        },


                        {
                            "data":
                                "tabungan_tujuan_nama"
                        },


                        {
                            "data":
                                "jumlah"
                        },


                        {
                            "data":
                                "keterangan"
                        },


                        {
                            "data":
                                "modified"
                        },


                        {
                            "data":
                                "modifier_user_name"
                        }


                    ]


                });


        }else{


            /*
            |--------------------------------------------------------------------------
            | PERILAKU ASLI
            |--------------------------------------------------------------------------
            */

            table.draw();


        }


    }



    /*
    |--------------------------------------------------------------------------
    | LOAD LIST
    |--------------------------------------------------------------------------
    */

    function load_list(){


        init_datatable();


    }



    /*
    |--------------------------------------------------------------------------
    | LOAD DETAIL
    |--------------------------------------------------------------------------
    |
    | TIDAK DIUBAH
    |
    */

    function load_detail(hash_id){


        ajax_get(


            "<?= base_url('transfer/ajax_detail') ?>/" +
            hash_id,


            {},


            function(resp){


                $("#modal-detail")
                    .modal(
                        "show"
                    );


                $("#modal-detail-body")
                    .html(
                        resp
                    );


            }


        );


    }



    /*
    |--------------------------------------------------------------------------
    | LOAD VIEW
    |--------------------------------------------------------------------------
    |
    | TIDAK DIUBAH
    |
    */

    function load_view(hash_id){


        ajax_get(


            "<?= base_url('transfer/ajax_view') ?>/" +
            hash_id,


            {},


            function(resp){


                $("#modal-view")
                    .modal(
                        "show"
                    );


                $("#modal-view-body")
                    .html(
                        resp
                    );


            }


        );


    }



    /*
    |--------------------------------------------------------------------------
    | SAVE
    |--------------------------------------------------------------------------
    |
    | LOGIC ASLI DIPERTAHANKAN
    |
    */

    function save(){


        var form_data =
            $("#form-detail")
                .serializeArray();


        ajax_post(


            "<?= base_url("transfer/ajax_save") ?>",


            form_data,


            function(resp){


                try {


                    var json =
                        JSON.parse(resp);


                    if(
                        json.is_success == 1
                    ){


                        show_toast(

                            "Success",

                            json.message,

                            "success"

                        );


                        $("#modal-detail")
                            .modal(
                                "hide"
                            );


                        load_list();


                    }else{


                        show_toast(

                            "Error",

                            json.message,

                            "error"

                        );


                    }


                }catch(error){


                    show_toast(

                        "Error",

                        "Application response error"

                    );


                }


            }


        );


    }



    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    |
    | FUNGSI ASLI TETAP DIPERTAHANKAN.
    | TIDAK DITAMBAHKAN KE TOMBOL KARENA USER MEMINTA
    | HANYA MENGUBAH TAMPILAN.
    |
    */

    function confirm_delete(hash_id){


        var confirmed =
            confirm(
                "Yakin ingin menghapus transfer ini ?"
            );


        if(!confirmed){

            return false;

        }


        ajax_get(


            "<?= base_url("transfer/ajax_delete") ?>/" +
            hash_id,


            {},


            function(resp){


                try {


                    var json =
                        JSON.parse(resp);


                    if(
                        json.is_success == 1
                    ){


                        show_toast(

                            "Success",

                            json.message,

                            "success"

                        );


                        $("#modal-detail")
                            .modal(
                                "hide"
                            );


                        load_list();


                    }else{


                        show_toast(

                            "Error",

                            json.message,

                            "error"

                        );


                    }


                }catch(error){


                    show_toast(

                        "Error",

                        "Application response error"

                    );


                }


            }


        );


    }


</script>


</body>

</html>