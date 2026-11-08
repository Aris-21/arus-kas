<?php

$user = get_session("user");

/* ============================================================
   SALDO TABUNGAN
   ============================================================ */

$saldo_tabungan_list = array();

foreach ($tabungan_list as $t) {

    $saldo_tabungan_list[$t['id']]['nama_tabungan'] = $t['nama'];
    $saldo_tabungan_list[$t['id']]['saldo'] = 0;

    foreach ($info_saldo_tabungan_list as $tabungan_id => $l) {

        if ((int)$tabungan_id == (int)$t['id']) {

            $saldo_tabungan_list[$tabungan_id]['saldo'] =
                (double)$l['saldo'];
        }
    }
}


/* ============================================================
   KATEGORI PEMASUKAN & PENGELUARAN
   ============================================================ */

$pengeluaran_kategori_list = array();
$pemasukkan_kategori_list  = array();

foreach ($total_kategori_list as $l) {

    $alur_kas = trim($l['alur_kas']);

    if ($alur_kas == "KELUAR") {
        $pengeluaran_kategori_list[] = $l;
    }

    if ($alur_kas == "MASUK") {
        $pemasukkan_kategori_list[] = $l;
    }
}


$max_pengeluaran_kategori_list = 5;
$max_pemasukkan_kategori_list  = 5;


/* ============================================================
   DONUT PEMASUKAN
   ============================================================ */

$total_kategori_pemasukan = 0;
$donut_kategori_pemasukan = array();

foreach ($pemasukkan_kategori_list as $index => $l) {

    $total_kategori_pemasukan +=
        (double)$l['total_masuk'];

    $selected = ($index == 0);

    $row = array(
        "name"     => $l['nama_kategori'],
        "y"        => (double)$l['total_masuk'],
        "slice"    => true,
        "selected" => $selected
    );

    $donut_kategori_pemasukan[] = $row;

    $count = $index + 1;

    if ($count == $max_pemasukkan_kategori_list) {
        break;
    }
}


/* ============================================================
   DONUT PENGELUARAN
   ============================================================ */

$total_kategori_pengeluaran = 0;
$donut_kategori_pengeluaran = array();

foreach ($pengeluaran_kategori_list as $index => $l) {

    $total_kategori_pengeluaran +=
        (double)$l['total_keluar'];

    $selected = ($index == 0);

    $row = array(
        "name"     => $l['nama_kategori'],
        "y"        => (double)$l['total_keluar'],
        "slice"    => true,
        "selected" => $selected
    );

    $donut_kategori_pengeluaran[] = $row;

    $count = $index + 1;

    if ($count == $max_pengeluaran_kategori_list) {
        break;
    }
}


/* ============================================================
   SPLINE BULAN INI
   ============================================================ */

$spline_total_per_day = array();

$spline_total_per_day['total_masuk']  = array();
$spline_total_per_day['total_keluar'] = array();

$categories = array();

$total_pemasukkan = 0;
$total_pengeluaran = 0;


if (
    isset($total_per_day_for_current_month)
    &&
    count($total_per_day_for_current_month) > 0
) {

    foreach (
        $total_per_day_for_current_month as $day => $l
    ) {

        $total_masuk  = 0;
        $total_keluar = 0;

        if (isset($l['total_masuk'])) {

            $total_masuk =
                (double)$l['total_masuk'];

            $total_pemasukkan +=
                $total_masuk;
        }

        if (isset($l['total_keluar'])) {

            $total_keluar =
                (double)$l['total_keluar'];

            $total_pengeluaran +=
                $total_keluar;
        }

        $spline_total_per_day['total_masuk'][] =
            $total_masuk;

        $spline_total_per_day['total_keluar'][] =
            $total_keluar;

        $categories[] =
            "$day " . date('M');
    }
}


/* ============================================================
   TOTAL SALDO
   ============================================================ */

$total_saldo = 0;

foreach ($saldo_tabungan_list as $saldo_item) {

    $total_saldo +=
        (double)$saldo_item['saldo'];
}

$saldo_formatted =
    "Rp. " .
    number_format(
        $total_saldo,
        0,
        ",",
        "."
    );


/* ============================================================
   NAMA USER
   ============================================================ */

$user_name = isset($user['name'])
    ? $user['name']
    : 'Pengguna';

?>

<!DOCTYPE html>

<html>

<head>

    <?php view("templates/meta") ?>

    <?php view("templates/style") ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.3/highcharts.js"></script>


    <style>

        /* =====================================================
           MODERN DASHBOARD
           ===================================================== */

        body {
            background: #f4f7fb;
        }


        .content-page {
            background: #f4f7fb;
        }


        .content {
            background: #f4f7fb;
        }


        .dashboard-container {
            padding-top: 25px;
            padding-bottom: 40px;
        }


        /* =====================================================
           WELCOME HEADER
           ===================================================== */

        .dashboard-welcome {

            position: relative;

            overflow: hidden;

            margin-bottom: 25px;

            padding: 27px 30px;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    #0d47a1 0%,
                    #1565c0 48%,
                    #1976d2 100%
                );

            color: #ffffff;

            box-shadow:
                0 10px 30px
                rgba(21, 101, 192, 0.20);
        }


        .dashboard-welcome::before {

            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            right: -70px;
            top: -100px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.07);
        }


        .dashboard-welcome::after {

            content: "";

            position: absolute;

            width: 150px;
            height: 150px;

            right: 90px;
            bottom: -100px;

            border-radius: 50%;

            background:
                rgba(255,255,255,0.05);
        }


        .welcome-content {

            position: relative;

            z-index: 2;
        }


        .welcome-small {

            display: inline-block;

            margin-bottom: 7px;

            padding: 5px 12px;

            border-radius: 50px;

            background:
                rgba(255,255,255,0.12);

            font-size: 11px;

            font-weight: 600;

            letter-spacing: .7px;

            text-transform: uppercase;
        }


        .dashboard-welcome h2 {

            margin:
                0 0 7px;

            color: #ffffff;

            font-size: 25px;

            font-weight: 700;
        }


        .dashboard-welcome p {

            max-width: 650px;

            margin: 0;

            color:
                rgba(255,255,255,.78);

            font-size: 13px;

            line-height: 1.6;
        }


        .welcome-date {

            position: absolute;

            right: 30px;

            top: 50%;

            z-index: 3;

            transform:
                translateY(-50%);

            padding:
                10px 15px;

            border:
                1px solid
                rgba(255,255,255,.15);

            border-radius: 10px;

            background:
                rgba(255,255,255,.08);

            color: #ffffff;

            font-size: 12px;
        }


        /* =====================================================
           SECTION TITLE
           ===================================================== */

        .dashboard-section-title {

            margin:
                4px 0 16px;

            font-size: 15px;

            font-weight: 700;

            color: #263b5e;
        }


        .dashboard-section-subtitle {

            margin-left: 7px;

            color: #9aa5b1;

            font-size: 11px;

            font-weight: 400;
        }


        /* =====================================================
           STAT CARDS
           ===================================================== */

        .stat-card {

            position: relative;

            overflow: hidden;

            min-height: 132px;

            margin-bottom: 22px;

            padding: 21px;

            background: #ffffff;

            border:
                1px solid #edf0f5;

            border-radius: 15px;

            box-shadow:
                0 5px 18px
                rgba(31,45,61,.055);

            transition:
                all .25s ease;
        }


        .stat-card:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 10px 28px
                rgba(31,45,61,.10);
        }


        .stat-top {

            display: flex;

            align-items: center;

            justify-content:
                space-between;

            margin-bottom: 17px;
        }


        .stat-label {

            margin: 0;

            color: #7b8794;

            font-size: 12px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: .3px;
        }


        .stat-icon {

            width: 42px;
            height: 42px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            font-size: 17px;
        }


        .stat-icon.blue {

            background: #e3f2fd;

            color: #1976d2;
        }


        .stat-icon.cyan {

            background: #e0f7fa;

            color: #0097a7;
        }


        .stat-icon.green {

            background: #e8f5e9;

            color: #43a047;
        }


        .stat-icon.red {

            background: #ffebee;

            color: #e53935;
        }


        .stat-value {

            margin: 0;

            color: #172b4d;

            font-size: 21px;

            font-weight: 700;

            line-height: 1.3;
        }


        .stat-description {

            margin-top: 5px;

            color: #a0aab7;

            font-size: 11px;
        }


        /* =====================================================
           MODERN PANEL
           ===================================================== */

        .modern-card {

            margin-bottom: 24px;

            overflow: hidden;

            background: #ffffff;

            border:
                1px solid #edf0f5;

            border-radius: 15px;

            box-shadow:
                0 5px 20px
                rgba(31,45,61,.055);
        }


        .modern-card-header {

            display: flex;

            align-items: center;

            justify-content:
                space-between;

            min-height: 63px;

            padding:
                16px 20px;

            border-bottom:
                1px solid #eef1f5;

            background: #ffffff;
        }


        .modern-card-title {

            margin: 0;

            color: #263b5e;

            font-size: 14px;

            font-weight: 700;
        }


        .modern-card-subtitle {

            display: block;

            margin-top: 3px;

            color: #9aa5b1;

            font-size: 10px;

            font-weight: 400;
        }


        .modern-card-icon {

            width: 35px;
            height: 35px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #eef6ff;

            color: #1976d2;
        }


        .modern-card-body {

            padding: 20px;
        }


        .modern-card-footer {

            padding:
                15px 20px;

            background: #f9fbfd;

            border-top:
                1px solid #eef1f5;
        }


        /* =====================================================
           BALANCE LIST
           ===================================================== */

        .balance-list {

            min-height: 292px;
        }


        .balance-item {

            display: flex;

            align-items: center;

            justify-content:
                space-between;

            padding:
                13px 0;

            border-bottom:
                1px solid #f0f2f5;
        }


        .balance-item:last-child {

            border-bottom: none;
        }


        .balance-left {

            display: flex;

            align-items: center;
        }


        .balance-icon {

            width: 35px;
            height: 35px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin-right: 11px;

            border-radius: 10px;

            background: #eef6ff;

            color: #1976d2;

            font-size: 13px;
        }


        .balance-name {

            color: #455a64;

            font-size: 12px;

            font-weight: 600;
        }


        .balance-value {

            color: #172b4d;

            font-size: 12px;

            font-weight: 700;

            text-align: right;
        }


        .balance-total-label {

            margin: 0;

            color: #657786;

            font-size: 12px;

            font-weight: 600;
        }


        .balance-total-value {

            margin: 0;

            color: #1565c0;

            font-size: 18px;

            font-weight: 700;
        }


        /* =====================================================
           CATEGORY CARDS
           ===================================================== */

        .category-income
        .modern-card-icon {

            background: #e8f5e9;

            color: #43a047;
        }


        .category-expense
        .modern-card-icon {

            background: #ffebee;

            color: #e53935;
        }


        .category-total {

            display: flex;

            align-items: center;

            justify-content:
                space-between;
        }


        .category-total span {

            color: #7b8794;

            font-size: 12px;

            font-weight: 600;
        }


        .category-total strong {

            color: #172b4d;

            font-size: 17px;
        }


        /* =====================================================
           HIGHCHART
           ===================================================== */

        #container-spline-current-month {

            width: 100%;

            height: 320px;
        }


        #container-kategori-pemasukan,
        #container-kategori-pengeluaran {

            width: 100%;

            min-height: 315px;
        }


        .highcharts-background {

            fill: transparent;
        }


        /* =====================================================
           RESPONSIVE
           ===================================================== */

        @media (max-width: 991px) {

            .welcome-date {

                position: relative;

                right: auto;
                top: auto;

                display: inline-block;

                margin-top: 15px;

                transform: none;
            }

        }


        @media (max-width: 767px) {

            .dashboard-container {

                padding-top: 15px;
            }


            .dashboard-welcome {

                padding: 22px;

                border-radius: 14px;
            }


            .dashboard-welcome h2 {

                font-size: 20px;
            }


            .stat-card {

                min-height: 125px;

                padding: 17px;
            }


            .stat-value {

                font-size: 17px;
            }


            .modern-card-header {

                padding: 15px;
            }


            .modern-card-body {

                padding: 15px;
            }

        }

    </style>

</head>


<body class="fixed-left">


<div id="wrapper">


    <!-- HEADER -->
    <?php view("templates/header") ?>


    <!-- SIDEBAR -->
    <?php view("templates/sidebar") ?>



    <!-- =====================================================
         CONTENT
         ===================================================== -->

    <div class="content-page">

        <div class="content">

            <div class="container dashboard-container">


                <!-- =================================================
                     WELCOME
                     ================================================= -->

                <div class="dashboard-welcome">

                    <div class="welcome-content">

                        <span class="welcome-small">
                            Dashboard
                        </span>


                        <h2>
                            Selamat Datang,
                            <?= htmlspecialchars(
                                $user_name,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </h2>


                        <p>
                            Pantau transaksi, saldo,
                            pemasukan dan pengeluaran
                            melalui ringkasan keuangan
                            pada dashboard Sistem Alur Kas.
                        </p>

                    </div>


                    <div class="welcome-date">

                        <i class="fa fa-calendar"></i>

                        &nbsp;

                        <?= date('d F Y') ?>

                    </div>

                </div>



                <!-- =================================================
                     STATISTIC
                     ================================================= -->

                <div class="dashboard-section-title">

                    Ringkasan Keuangan

                    <span class="dashboard-section-subtitle">
                        Bulan <?= date('F Y') ?>
                    </span>

                </div>


                <div class="row">


                    <!-- TRANSAKSI -->

                    <div class="col-md-3 col-sm-6">

                        <div class="stat-card">

                            <div class="stat-top">

                                <h4 class="stat-label">
                                    Transaksi
                                </h4>


                                <div class="stat-icon blue">

                                    <i class="fa fa-exchange"></i>

                                </div>

                            </div>


                            <h3 class="stat-value">

                                <?= isset($total_transaction)
                                    ? number_format(
                                        $total_transaction,
                                        0,
                                        ",",
                                        "."
                                    )
                                    : 0 ?>

                            </h3>


                            <div class="stat-description">

                                Transaksi bulan ini

                            </div>

                        </div>

                    </div>



                    <!-- SALDO -->

                    <div class="col-md-3 col-sm-6">

                        <div class="stat-card">

                            <div class="stat-top">

                                <h4 class="stat-label">
                                    Total Saldo
                                </h4>


                                <div class="stat-icon cyan">

                                    <i class="fa fa-money"></i>

                                </div>

                            </div>


                            <h3
                                class="stat-value"
                                id="total-saldo"
                            >

                                <?= $saldo_formatted ?>

                            </h3>


                            <div class="stat-description">

                                Saldo seluruh tabungan

                            </div>

                        </div>

                    </div>



                    <!-- PEMASUKAN -->

                    <div class="col-md-3 col-sm-6">

                        <div class="stat-card">

                            <div class="stat-top">

                                <h4 class="stat-label">
                                    Pemasukan
                                </h4>


                                <div class="stat-icon green">

                                    <i class="fa fa-arrow-down"></i>

                                </div>

                            </div>


                            <h3 class="stat-value">

                                Rp.
                                <?= number_format(
                                    $total_pemasukkan,
                                    0,
                                    ",",
                                    "."
                                ) ?>

                            </h3>


                            <div class="stat-description">

                                Pemasukan bulan ini

                            </div>

                        </div>

                    </div>



                    <!-- PENGELUARAN -->

                    <div class="col-md-3 col-sm-6">

                        <div class="stat-card">

                            <div class="stat-top">

                                <h4 class="stat-label">
                                    Pengeluaran
                                </h4>


                                <div class="stat-icon red">

                                    <i class="fa fa-arrow-up"></i>

                                </div>

                            </div>


                            <h3 class="stat-value">

                                Rp.
                                <?= number_format(
                                    $total_pengeluaran,
                                    0,
                                    ",",
                                    "."
                                ) ?>

                            </h3>


                            <div class="stat-description">

                                Pengeluaran bulan ini

                            </div>

                        </div>

                    </div>


                </div>



                <!-- =================================================
                     CASH FLOW + BALANCE
                     ================================================= -->

                <div class="row">


                    <!-- CASH FLOW -->

                    <div class="col-md-8">

                        <div class="modern-card">

                            <div class="modern-card-header">

                                <div>

                                    <h3 class="modern-card-title">

                                        Grafik Alur Kas

                                        <span class="modern-card-subtitle">

                                            Pergerakan pemasukan dan
                                            pengeluaran bulan
                                            <?= date("F Y") ?>

                                        </span>

                                    </h3>

                                </div>


                                <div class="modern-card-icon">

                                    <i class="fa fa-line-chart"></i>

                                </div>

                            </div>


                            <div class="modern-card-body">

                                <div
                                    id="container-spline-current-month"
                                ></div>

                            </div>

                        </div>

                    </div>



                    <!-- SALDO TABUNGAN -->

                    <div class="col-md-4">

                        <div class="modern-card">

                            <div class="modern-card-header">

                                <div>

                                    <h3 class="modern-card-title">

                                        Saldo Tabungan

                                        <span class="modern-card-subtitle">

                                            Posisi saldo per
                                            <?= date('d F Y') ?>

                                        </span>

                                    </h3>

                                </div>


                                <div class="modern-card-icon">

                                    <i class="fa fa-credit-card"></i>

                                </div>

                            </div>


                            <div
                                class="modern-card-body balance-list"
                            >

                                <?php

                                if (
                                    count(
                                        $saldo_tabungan_list
                                    ) > 0
                                ) {

                                    foreach (
                                        $saldo_tabungan_list
                                        as $l
                                    ) {

                                ?>

                                    <div class="balance-item">

                                        <div class="balance-left">

                                            <div class="balance-icon">

                                                <i class="fa fa-bank"></i>

                                            </div>


                                            <div class="balance-name">

                                                <?= htmlspecialchars(
                                                    $l['nama_tabungan'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>

                                            </div>

                                        </div>


                                        <div class="balance-value">

                                            Rp.
                                            <?= number_format(
                                                (double)$l['saldo'],
                                                0,
                                                ",",
                                                "."
                                            ) ?>

                                        </div>

                                    </div>

                                <?php

                                    }

                                } else {

                                ?>

                                    <div
                                        style="
                                            text-align:center;
                                            padding:40px 0;
                                            color:#9aa5b1;
                                        "
                                    >

                                        Belum ada data tabungan.

                                    </div>

                                <?php

                                }

                                ?>

                            </div>


                            <div class="modern-card-footer">

                                <div class="category-total">

                                    <span>
                                        Total Saldo
                                    </span>


                                    <strong>

                                        <?= $saldo_formatted ?>

                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>



                <!-- =================================================
                     CATEGORY
                     ================================================= -->

                <div class="dashboard-section-title">

                    Analisis Kategori

                    <span class="dashboard-section-subtitle">
                        5 kategori terbesar bulan ini
                    </span>

                </div>


                <div class="row">


                    <!-- PEMASUKAN -->

                    <div class="col-md-6">

                        <div
                            class="
                                modern-card
                                category-income
                            "
                        >

                            <div class="modern-card-header">

                                <div>

                                    <h3 class="modern-card-title">

                                        Kategori Pemasukan

                                        <span class="modern-card-subtitle">

                                            <?= $max_pemasukkan_kategori_list ?>
                                            kategori pemasukan terbesar

                                        </span>

                                    </h3>

                                </div>


                                <div class="modern-card-icon">

                                    <i class="fa fa-arrow-down"></i>

                                </div>

                            </div>


                            <div class="modern-card-body">

                                <div
                                    id="container-kategori-pemasukan"
                                ></div>

                            </div>


                            <div class="modern-card-footer">

                                <div class="category-total">

                                    <span>
                                        Total Pemasukan
                                    </span>


                                    <strong>

                                        Rp.
                                        <?= number_format(
                                            $total_kategori_pemasukan,
                                            0,
                                            ",",
                                            "."
                                        ) ?>

                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- PENGELUARAN -->

                    <div class="col-md-6">

                        <div
                            class="
                                modern-card
                                category-expense
                            "
                        >

                            <div class="modern-card-header">

                                <div>

                                    <h3 class="modern-card-title">

                                        Kategori Pengeluaran

                                        <span class="modern-card-subtitle">

                                            <?= $max_pengeluaran_kategori_list ?>
                                            kategori pengeluaran terbesar

                                        </span>

                                    </h3>

                                </div>


                                <div class="modern-card-icon">

                                    <i class="fa fa-arrow-up"></i>

                                </div>

                            </div>


                            <div class="modern-card-body">

                                <div
                                    id="container-kategori-pengeluaran"
                                ></div>

                            </div>


                            <div class="modern-card-footer">

                                <div class="category-total">

                                    <span>
                                        Total Pengeluaran
                                    </span>


                                    <strong>

                                        Rp.
                                        <?= number_format(
                                            $total_kategori_pengeluaran,
                                            0,
                                            ",",
                                            "."
                                        ) ?>

                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>


            </div>

        </div>


        <?php view("templates/footer") ?>


    </div>

</div>



<?php view("templates/script") ?>



<script>

$(document).ready(function () {


    /* =========================================================
       GLOBAL HIGHCHART STYLE
       ========================================================= */

    Highcharts.setOptions({

        lang: {
            thousandsSep: '.'
        },

        chart: {

            style: {
                fontFamily:
                    '"Segoe UI", Arial, sans-serif'
            }

        }

    });



    /* =========================================================
       PEMASUKAN
       ========================================================= */

    Highcharts.chart(
        'container-kategori-pemasukan',
        {

            chart: {

                type: 'pie',

                backgroundColor:
                    'transparent',

                spacing: [
                    10,
                    10,
                    10,
                    10
                ]

            },


            title: {
                text: ''
            },


            tooltip: {

                pointFormat:
                    '<b>Rp. {point.y:,.0f}</b>'

            },


            plotOptions: {

                pie: {

                    allowPointSelect: true,

                    cursor: 'pointer',

                    innerSize: '58%',

                    borderWidth: 0,

                    dataLabels: {

                        enabled: true,

                        distance: 15,

                        style: {

                            fontSize: '10px',

                            fontWeight: '500',

                            color: '#657786',

                            textOutline: 'none'

                        },

                        format:
                            '{point.name}<br>' +
                            '<b>Rp. {point.y:,.0f}</b>'

                    }

                }

            },


            credits: {
                enabled: false
            },


            exporting: {
                enabled: false
            },


            series: [{

                type: 'pie',

                name: 'Pemasukan',

                data:
                    <?= json_encode(
                        $donut_kategori_pemasukan
                    ) ?>

            }]

        }
    );



    /* =========================================================
       PENGELUARAN
       ========================================================= */

    Highcharts.chart(
        'container-kategori-pengeluaran',
        {

            chart: {

                type: 'pie',

                backgroundColor:
                    'transparent',

                spacing: [
                    10,
                    10,
                    10,
                    10
                ]

            },


            title: {
                text: ''
            },


            tooltip: {

                pointFormat:
                    '<b>Rp. {point.y:,.0f}</b>'

            },


            plotOptions: {

                pie: {

                    allowPointSelect: true,

                    cursor: 'pointer',

                    innerSize: '58%',

                    borderWidth: 0,

                    dataLabels: {

                        enabled: true,

                        distance: 15,

                        style: {

                            fontSize: '10px',

                            fontWeight: '500',

                            color: '#657786',

                            textOutline: 'none'

                        },

                        format:
                            '{point.name}<br>' +
                            '<b>Rp. {point.y:,.0f}</b>'

                    }

                }

            },


            credits: {
                enabled: false
            },


            exporting: {
                enabled: false
            },


            series: [{

                type: 'pie',

                name: 'Pengeluaran',

                data:
                    <?= json_encode(
                        $donut_kategori_pengeluaran
                    ) ?>

            }]

        }
    );



    /* =========================================================
       CASH FLOW
       ========================================================= */

    Highcharts.chart(
        'container-spline-current-month',
        {

            chart: {

                type: 'spline',

                backgroundColor:
                    'transparent',

                spacingTop: 20

            },


            title: {
                text: ''
            },


            subtitle: {
                text: ''
            },


            xAxis: {

                categories:
                    <?= json_encode(
                        $categories
                    ) ?>,

                lineColor:
                    '#e7ebf0',

                tickColor:
                    '#e7ebf0',

                labels: {

                    style: {

                        color: '#8b98a8',

                        fontSize: '10px'

                    }

                }

            },


            yAxis: {

                gridLineColor:
                    '#eef1f5',

                title: {
                    text: ''
                },

                labels: {

                    style: {

                        color: '#8b98a8',

                        fontSize: '10px'

                    },

                    formatter:
                        function () {

                            if (
                                this.value >=
                                1000000
                            ) {

                                return (
                                    'Rp. ' +
                                    (
                                        this.value /
                                        1000000
                                    ) +
                                    ' jt'
                                );

                            }

                            if (
                                this.value >=
                                1000
                            ) {

                                return (
                                    'Rp. ' +
                                    (
                                        this.value /
                                        1000
                                    ) +
                                    ' rb'
                                );

                            }

                            return (
                                'Rp. ' +
                                this.value
                            );

                        }

                }

            },


            tooltip: {

                shared: true,

                valuePrefix:
                    'Rp. ',

                valueDecimals: 0

            },


            legend: {

                itemStyle: {

                    color: '#657786',

                    fontSize: '10px',

                    fontWeight: '500'

                }

            },


            plotOptions: {

                spline: {

                    lineWidth: 3,

                    marker: {

                        enabled: true,

                        radius: 3

                    },

                    states: {

                        hover: {

                            lineWidth: 4

                        }

                    }

                }

            },


            credits: {
                enabled: false
            },


            exporting: {
                enabled: false
            },


            series: [

                {

                    name:
                        'Pemasukan',

                    color:
                        '#43A047',

                    data:
                        <?= json_encode(
                            $spline_total_per_day[
                                'total_masuk'
                            ]
                        ) ?>

                },

                {

                    name:
                        'Pengeluaran',

                    color:
                        '#E53935',

                    data:
                        <?= json_encode(
                            $spline_total_per_day[
                                'total_keluar'
                            ]
                        ) ?>

                }

            ]

        }
    );


});

</script>


</body>

</html>