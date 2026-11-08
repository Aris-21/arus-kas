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
         MODERN ALUR KAS STYLE
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

        .alur-page {
            padding-top: 5px;
            padding-bottom: 30px;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGE HEADER
        |--------------------------------------------------------------------------
        */

        .alur-page-header {
            margin-bottom: 22px;
        }

        .alur-page-title {
            margin: 0;
            color: #172554;
            font-size: 24px;
            font-weight: 700;
        }

        .alur-page-subtitle {
            color: #7b8794;
            font-size: 13px;
            margin-top: 6px;
        }


        /*
        |--------------------------------------------------------------------------
        | SUMMARY CARD
        |--------------------------------------------------------------------------
        */

        .cash-summary-card {
            position: relative;

            background: #ffffff;

            border: 0;

            border-radius: 14px;

            padding: 22px;

            min-height: 132px;

            margin-bottom: 20px;

            box-shadow:
                0 4px 18px
                rgba(15, 23, 42, 0.07);

            overflow: hidden;

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }


        .cash-summary-card:hover {

            transform: translateY(-2px);

            box-shadow:
                0 8px 25px
                rgba(15, 23, 42, 0.10);
        }


        .cash-summary-card:before {

            content: "";

            position: absolute;

            top: 0;

            left: 0;

            right: 0;

            height: 4px;
        }


        .cash-summary-card.balance:before {
            background: #2563eb;
        }


        .cash-summary-card.income:before {
            background: #16a34a;
        }


        .cash-summary-card.expense:before {
            background: #dc2626;
        }


        /*
        |--------------------------------------------------------------------------
        | SUMMARY ICON
        |--------------------------------------------------------------------------
        */

        .cash-icon {

            width: 48px;

            height: 48px;

            border-radius: 12px;

            display: inline-block;

            text-align: center;

            line-height: 48px;

            font-size: 21px;

            float: left;

            margin-right: 15px;
        }


        .cash-icon.balance {

            background: #eff6ff;

            color: #2563eb;
        }


        .cash-icon.income {

            background: #f0fdf4;

            color: #16a34a;
        }


        .cash-icon.expense {

            background: #fef2f2;

            color: #dc2626;
        }


        /*
        |--------------------------------------------------------------------------
        | SUMMARY TEXT
        |--------------------------------------------------------------------------
        */

        .cash-summary-content {

            overflow: hidden;
        }


        .cash-summary-label {

            color: #64748b;

            font-size: 12px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: .4px;

            margin-bottom: 8px;
        }


        .cash-summary-value {

            color: #172554;

            font-size: 21px;

            font-weight: 700;

            line-height: 1.2;
        }


        .cash-summary-date {

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
        | BUTTON
        |--------------------------------------------------------------------------
        */

        .btn-modern {

            border: 0;

            border-radius: 7px;

            font-size: 12px;

            font-weight: 600;

            padding: 8px 14px;

            margin-left: 5px;

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


        .btn-modern-print {

            background: #0f766e;

            color: #ffffff;
        }


        .btn-modern-print:hover,
        .btn-modern-print:focus {

            background: #115e59;

            color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | ACTION BUTTONS
        |--------------------------------------------------------------------------
        */

        .cash-action-group {

            display: inline-flex;

            white-space: nowrap;
        }


        .cash-action-btn {

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


        .cash-action-view {

            background: #e0f2fe;

            color: #0369a1;
        }


        .cash-action-view:hover {

            background: #0369a1;

            color: #ffffff;
        }


        .cash-action-edit {

            background: #fef3c7;

            color: #b45309;
        }


        .cash-action-edit:hover {

            background: #d97706;

            color: #ffffff;
        }


        .cash-action-delete {

            background: #fee2e2;

            color: #dc2626;
        }


        .cash-action-delete:hover {

            background: #dc2626;

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
        | SEARCH
        |--------------------------------------------------------------------------
        */

        .search-input-text {

            border: 1px solid #dbe3ec !important;

            border-radius: 6px !important;

            box-shadow: none !important;

            font-size: 11px;
        }


        .search-input-text:focus {

            border-color: #2563eb !important;
        }


        /*
        |--------------------------------------------------------------------------
        | DATATABLE UI
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
        }


        .modern-modal
        .modal-body {

            padding: 22px;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media(max-width: 767px){

            .alur-page-title {

                font-size: 20px;
            }


            .cash-summary-value {

                font-size: 17px;
            }


            .modern-panel-header
            .pull-right {

                float: none !important;

                margin-bottom: 12px;
            }


            .btn-modern {

                margin-left: 0;

                margin-right: 4px;

                margin-bottom: 5px;
            }

        }

    </style>

</head>


<body class="fixed-left">


<div id="wrapper">


    <?php view("templates/header") ?>

    <?php view("templates/sidebar") ?>


    <!-- =========================================================
         CONTENT
    ========================================================== -->

    <div class="content-page">

        <div class="content">

            <div class="container alur-page">


                <!-- =====================================================
                     PAGE TITLE
                ====================================================== -->

                <div class="alur-page-header">

                    <h2 class="alur-page-title">

                        Alur Kas

                    </h2>

                    <div class="alur-page-subtitle">

                        Kelola transaksi pemasukan,
                        pengeluaran dan saldo kas.

                    </div>

                </div>



                <!-- =====================================================
                     SUMMARY
                ====================================================== -->

                <div class="row">


                    <!-- SALDO -->

                    <div class="col-md-4 col-sm-6">

                        <div class="cash-summary-card balance">

                            <div class="cash-icon balance">

                                <i class="fa fa-money"></i>

                            </div>


                            <div class="cash-summary-content">

                                <div class="cash-summary-label">

                                    Saldo Hari Ini

                                </div>


                                <div
                                    class="cash-summary-value"
                                    id="total-saldo"
                                >

                                    Rp. 0

                                </div>


                                <div class="cash-summary-date">

                                    <?= date("d M Y") ?>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- PEMASUKAN -->

                    <div class="col-md-4 col-sm-6">

                        <div class="cash-summary-card income">

                            <div class="cash-icon income">

                                <i class="fa fa-arrow-down"></i>

                            </div>


                            <div class="cash-summary-content">

                                <div class="cash-summary-label">

                                    Pemasukan Bulan Ini

                                </div>


                                <div
                                    class="cash-summary-value"
                                    id="total-pemasukkan-bulan-ini"
                                >

                                    Rp. 0

                                </div>


                                <div class="cash-summary-date">

                                    Total penerimaan bulan berjalan

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- PENGELUARAN -->

                    <div class="col-md-4 col-sm-6">

                        <div class="cash-summary-card expense">

                            <div class="cash-icon expense">

                                <i class="fa fa-arrow-up"></i>

                            </div>


                            <div class="cash-summary-content">

                                <div class="cash-summary-label">

                                    Pengeluaran Bulan Ini

                                </div>


                                <div
                                    class="cash-summary-value"
                                    id="total-pengeluaran-bulan-ini"
                                >

                                    Rp. 0

                                </div>


                                <div class="cash-summary-date">

                                    Total pengeluaran bulan berjalan

                                </div>

                            </div>

                        </div>

                    </div>


                </div>



                <!-- =====================================================
                     TRANSACTION PANEL
                ====================================================== -->

                <div class="row">

                    <div class="col-md-12">


                        <div class="modern-panel">


                            <!-- HEADER -->

                            <div class="modern-panel-header">


                                <div class="pull-right">


                                    <button
                                        type="button"
                                        class="
                                            btn
                                            btn-modern
                                            btn-modern-print
                                        "
                                        onclick="load_cetak()"
                                    >

                                        <i class="fa fa-print"></i>

                                        &nbsp;

                                        Cetak

                                    </button>


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

                                        Tambah Transaksi

                                    </button>


                                </div>


                                <h3 class="modern-panel-title">

                                    Data Transaksi Alur Kas

                                </h3>


                                <div class="modern-panel-subtitle">

                                    Daftar seluruh transaksi
                                    pemasukan dan pengeluaran.

                                </div>


                                <div class="clearfix"></div>

                            </div>



                            <!-- BODY -->

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


                                        <thead>

                                        <tr>

                                            <th style="width:45px;">
                                                #
                                            </th>

                                            <th style="width:115px;">
                                                Aksi
                                            </th>

                                            <th>
                                                No. Kas
                                            </th>

                                            <th>
                                                Tanggal
                                            </th>

                                            <th>
                                                Kategori
                                            </th>

                                            <th>
                                                Tabungan
                                            </th>

                                            <th>
                                                Jumlah Masuk
                                            </th>

                                            <th>
                                                Jumlah Keluar
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


                                            <th>

                                                <input
                                                    type="text"
                                                    class="
                                                        form-control
                                                        search-input-text
                                                        input-sm
                                                    "
                                                    data-column="8"
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
                                                    data-column="10"
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
         MODAL DETAIL / EDIT
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
                    >

                        <span>&times;</span>

                    </button>


                    <h3 class="modal-title">

                        <span id="modal-title"></span>

                        Alur Kas

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
                    >

                        <span>&times;</span>

                    </button>


                    <h3 class="modal-title">

                        Detail Alur Kas

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



    <!-- =========================================================
         MODAL CETAK
    ========================================================== -->

    <div
        class="modal fade modern-modal"
        id="modal-cetak"
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
                    >

                        <span>&times;</span>

                    </button>


                    <h3 class="modal-title">

                        <i class="fa fa-print"></i>

                        &nbsp;

                        Cetak Laporan Alur Kas

                    </h3>


                </div>



                <div
                    class="modal-body"
                    id="modal-cetak-body"
                >


                    <form
                        class="form-horizontal"
                        method="get"
                        autocomplete="off"
                        action="<?= base_url("alur_kas/cetak") ?>"
                        id="form-filter-cetak"
                        target="_blank"
                    >


                        <div class="form-group">


                            <label
                                class="
                                    control-label
                                    col-sm-3
                                "
                            >

                                Periode

                            </label>


                            <div class="col-sm-9">


                                <div
                                    class="
                                        input-daterange
                                        input-group
                                    "
                                    id="date-range"
                                >


                                    <input
                                        type="text"
                                        autocomplete="off"
                                        class="
                                            form-control
                                            input-filter
                                        "
                                        name="start_date"
                                        placeholder="Tanggal awal"
                                        required
                                    >


                                    <span
                                        class="
                                            input-group-addon
                                            bg-primary
                                            b-0
                                            text-white
                                        "
                                    >

                                        s/d

                                    </span>


                                    <input
                                        type="text"
                                        autocomplete="off"
                                        class="
                                            form-control
                                            input-filter
                                        "
                                        name="end_date"
                                        placeholder="Tanggal akhir"
                                        required
                                    >


                                </div>


                            </div>

                        </div>


                        <hr>


                        <div class="form-group">

                            <div
                                class="col-sm-12"
                                style="text-align:right;"
                            >


                                <button
                                    type="submit"
                                    class="
                                        btn
                                        btn-success
                                    "
                                >

                                    <i class="fa fa-print"></i>

                                    &nbsp;

                                    Cetak Laporan

                                </button>


                                <button
                                    type="button"
                                    class="
                                        btn
                                        btn-default
                                    "
                                    data-dismiss="modal"
                                >

                                    <i class="fa fa-times"></i>

                                    &nbsp;

                                    Tutup

                                </button>


                            </div>

                        </div>


                    </form>


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
            "Alur Kas"
        );


        /*
        |--------------------------------------------------------------------------
        | DATE PICKER
        |--------------------------------------------------------------------------
        */

        $('#date-range').datepicker({

            toggleActive: true,

            autoclose: true

        });


        /*
        |--------------------------------------------------------------------------
        | DATATABLE
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

                var i = $(this).attr(
                    'data-column'
                );

                var v = $(this).val();


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

                var i = $(this).attr(
                    'data-column'
                );

                var v = $(this).val();


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

        $("#datatable_filter input").unbind();


        $("#datatable_filter input").bind(
            "keyup",
            function(e){

                var v = this.value;


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


            table = $("#datatable").DataTable({


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
                */

                "ajax": {

                    "url":
                        "<?= site_url('alur_kas/ajax_list') ?>",

                    "type":
                        "GET",


                    beforeSend: function(xhr){

                        $("#loader").show();

                    },


                    complete: function(
                        jqXHR,
                        textStatus
                    ){

                        $("#loader").hide();

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
                | PAGE LENGTH
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
                    | NOMOR
                    |--------------------------------------------------------------------------
                    */

                    {

                        "targets": 0,

                        "orderable": false,

                        "responsivePriority": 1

                    },



                    /*
                    |--------------------------------------------------------------------------
                    | AKSI
                    |--------------------------------------------------------------------------
                    */

                    {

                        "targets": 1,

                        "orderable": false,

                        "responsivePriority": 1,

                        "data": null,


                        render: function(
                            data,
                            type,
                            row
                        ){


                            var html = [];


                            /*
                            |--------------------------------------------------------------------------
                            | ALLOW EDIT
                            |--------------------------------------------------------------------------
                            */

                            var allow_edit = 0;


                            if(
                                data.allow_edit != null &&
                                data.allow_edit != undefined
                            ){

                                allow_edit =
                                    parseInt(
                                        data.allow_edit
                                    );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | CONTAINER
                            |--------------------------------------------------------------------------
                            */

                            html.push(

                                "<div " +

                                "class='cash-action-group'>"

                            );



                            /*
                            |--------------------------------------------------------------------------
                            | LIHAT
                            |--------------------------------------------------------------------------
                            */

                            html.push(

                                "<button " +

                                "type='button' " +

                                "class='" +
                                "cash-action-btn " +
                                "cash-action-view' " +

                                "title='Lihat' " +

                                "onclick=\"" +
                                "load_view('" +
                                data.hash_id +
                                "')" +
                                "\">" +

                                "<i class='fa fa-eye'></i>" +

                                "</button>"

                            );



                            /*
                            |--------------------------------------------------------------------------
                            | EDIT
                            |--------------------------------------------------------------------------
                            */

                            if(allow_edit == 1){


                                html.push(

                                    "<button " +

                                    "type='button' " +

                                    "class='" +
                                    "cash-action-btn " +
                                    "cash-action-edit' " +

                                    "title='Edit' " +

                                    "onclick=\"" +
                                    "load_detail('" +
                                    data.hash_id +
                                    "')" +
                                    "\">" +

                                    "<i class='fa fa-edit'></i>" +

                                    "</button>"

                                );



                                /*
                                |--------------------------------------------------------------------------
                                | DELETE
                                |--------------------------------------------------------------------------
                                |
                                | Tombol delete ditempatkan langsung di sini.
                                | Transaksi yang bisa diedit juga bisa dihapus.
                                |
                                */

                                html.push(

                                    "<button " +

                                    "type='button' " +

                                    "class='" +
                                    "cash-action-btn " +
                                    "cash-action-delete' " +

                                    "title='Hapus' " +

                                    "onclick=\"" +
                                    "confirm_delete('" +
                                    data.hash_id +
                                    "')" +
                                    "\">" +

                                    "<i class='fa fa-trash'></i>" +

                                    "</button>"

                                );

                            }


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
                            "no_kas_number_formatted"
                    },

                    {
                        "data":
                            "tanggal"
                    },

                    {
                        "data":
                            "kategori_nama"
                    },

                    {
                        "data":
                            "tabungan_nama"
                    },

                    {
                        "data":
                            "jumlah_masuk"
                    },

                    {
                        "data":
                            "jumlah_keluar"
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
            | RELOAD EXISTING TABLE
            |--------------------------------------------------------------------------
            */

            table.ajax.reload(
                null,
                false
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD INFO
        |--------------------------------------------------------------------------
        */

        get_dashboard_info();

    }



    /*
    |--------------------------------------------------------------------------
    | DASHBOARD INFO
    |--------------------------------------------------------------------------
    */

    function get_dashboard_info(){


        ajax_get(

            "<?= base_url('alur_kas/ajax_get_dashboard_info') ?>/",

            {},

            function(resp){


                try {


                    var json =
                        JSON.parse(resp);


                    if(
                        json.is_success == 1
                    ){


                        var data =
                            json.data;


                        $("#total-saldo")
                            .html(
                                data.total_saldo
                            );


                        $("#total-pemasukkan-bulan-ini")
                            .html(
                                data.total_pemasukkan
                            );


                        $("#total-pengeluaran-bulan-ini")
                            .html(
                                data.total_pengeluaran
                            );


                    }else{


                        show_toast(

                            "Error",

                            json.message,

                            "error"

                        );

                    }


                }catch(error){


                    console.log(resp);


                    show_toast(

                        "Error",

                        "Application response error",

                        "error"

                    );

                }

            }

        );

    }



    /*
    |--------------------------------------------------------------------------
    | LOAD LIST
    |--------------------------------------------------------------------------
    */

    function load_list(){


        if(
            table &&
            $.fn.DataTable.isDataTable(
                "#datatable"
            )
        ){


            table.ajax.reload(
                null,
                false
            );


        }else{


            init_datatable();

        }


        get_dashboard_info();

    }



    /*
    |--------------------------------------------------------------------------
    | CETAK
    |--------------------------------------------------------------------------
    */

    function load_cetak(){


        $("#modal-cetak").modal(
            "show"
        );

    }



    /*
    |--------------------------------------------------------------------------
    | DETAIL / EDIT
    |--------------------------------------------------------------------------
    */

    function load_detail(hash_id){


        ajax_get(

            "<?= base_url('alur_kas/ajax_detail') ?>/" +
            hash_id,

            {},

            function(resp){


                $("#modal-detail").modal(
                    "show"
                );


                $("#modal-detail-body").html(
                    resp
                );

            }

        );

    }



    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    function load_view(hash_id){


        ajax_get(

            "<?= base_url('alur_kas/ajax_view') ?>/" +
            hash_id,

            {},

            function(resp){


                $("#modal-view").modal(
                    "show"
                );


                $("#modal-view-body").html(
                    resp
                );

            }

        );

    }



    /*
    |--------------------------------------------------------------------------
    | SAVE
    |--------------------------------------------------------------------------
    */

    function save(){


        var form_data =
            $("#form-detail")
            .serializeArray();


        ajax_post(

            "<?= base_url('alur_kas/ajax_save') ?>",

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


                        $("#modal-detail").modal(
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


                    console.log(resp);


                    show_toast(

                        "Error",

                        "Application response error",

                        "error"

                    );

                }

            }

        );

    }



    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    function confirm_delete(hash_id){


        /*
        |--------------------------------------------------------------------------
        | VALIDASI HASH
        |--------------------------------------------------------------------------
        */

        if(
            hash_id == null ||
            hash_id == undefined ||
            hash_id == ""
        ){


            show_toast(

                "Error",

                "ID transaksi tidak ditemukan.",

                "error"

            );


            return false;

        }



        /*
        |--------------------------------------------------------------------------
        | KONFIRMASI
        |--------------------------------------------------------------------------
        */

        var confirmed = confirm(

            "Yakin ingin menghapus transaksi Alur Kas ini?\n\n" +

            "Data yang sudah dihapus tidak dapat dikembalikan."

        );


        if(!confirmed){

            return false;

        }



        /*
        |--------------------------------------------------------------------------
        | DELETE REQUEST
        |--------------------------------------------------------------------------
        */

        ajax_get(

            "<?= base_url('alur_kas/ajax_delete') ?>/" +
            hash_id,

            {},

            function(resp){


                try {


                    var json =
                        JSON.parse(resp);



                    /*
                    |--------------------------------------------------------------------------
                    | SUCCESS
                    |--------------------------------------------------------------------------
                    */

                    if(
                        json.is_success == 1
                    ){


                        show_toast(

                            "Success",

                            json.message,

                            "success"

                        );



                        /*
                        |--------------------------------------------------------------------------
                        | CLOSE MODAL
                        |--------------------------------------------------------------------------
                        */

                        $("#modal-detail")
                            .modal("hide");


                        $("#modal-view")
                            .modal("hide");



                        /*
                        |--------------------------------------------------------------------------
                        | RELOAD TABLE
                        |--------------------------------------------------------------------------
                        */

                        if(
                            table &&
                            $.fn.DataTable.isDataTable(
                                "#datatable"
                            )
                        ){


                            table.ajax.reload(

                                null,

                                false

                            );


                        }else{


                            init_datatable();

                        }



                        /*
                        |--------------------------------------------------------------------------
                        | REFRESH SUMMARY
                        |--------------------------------------------------------------------------
                        */

                        get_dashboard_info();


                    }else{


                        /*
                        |--------------------------------------------------------------------------
                        | SERVER ERROR
                        |--------------------------------------------------------------------------
                        */

                        show_toast(

                            "Error",

                            json.message,

                            "error"

                        );

                    }


                }catch(error){


                    console.log(
                        "Delete response:",
                        resp
                    );


                    console.log(
                        "Delete error:",
                        error
                    );


                    show_toast(

                        "Error",

                        "Application response error",

                        "error"

                    );

                }

            }

        );

    }


</script>


</body>

</html>