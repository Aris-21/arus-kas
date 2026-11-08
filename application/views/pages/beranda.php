<!DOCTYPE html>
<?php

$saldo_tabungan_list= array();
foreach ($tabungan_list as $t) {
    $saldo_tabungan_list[$t['id']]['nama_tabungan'] = $t['nama'];
    $saldo_tabungan_list[$t['id']]['saldo'] = 0;
    
    foreach ($info_saldo_tabungan_list as $tabungan_id => $l) {
        if((int)$tabungan_id == (int)$t['id']){
            $saldo_tabungan_list[$tabungan_id]['saldo'] = (double)$l['saldo'];
        }
    }
}

$pengeluaran_kategori_list = array();
$pemasukkan_kategori_list = array();
foreach ($total_kategori_list as $l) {
    $alur_kas = trim($l['alur_kas']);
    
    if($alur_kas == "KELUAR"){
        $pengeluaran_kategori_list[] = $l;
    }
    
    if($alur_kas == "MASUK"){        
        $pemasukkan_kategori_list[] = $l;
    }
}

$max_pengeluaran_kategori_list = 5;
$max_pemasukkan_kategori_list = 5;

// =============================================================================
// SET the Donut Chart
// =============================================================================
// DONUT PEMASUKAN
$total_kategori_pemasukan = 0;
$donut_kategori_pemasukan = array();

foreach ($pemasukkan_kategori_list as $index => $l) {
    $total_kategori_pemasukan += (double) $l['total_masuk'];
        
    $slice = true;
    $selected = true;
    
    if($index > 0){        
        $selected = false;
    }
    
    $row = array(
        "name" => $l['nama_kategori'],
        "y" => (double) $l['total_masuk'],
        "slice" => $slice, 
        "selected" => $selected
    );
    
    $donut_kategori_pemasukan[] = $row;
    
    $count = $index + 1;
    if($count == $max_pemasukkan_kategori_list) break;
}

// DONUT PENGELUARAN
$total_kategori_pengeluaran = 0;
$donut_kategori_pengeluaran = array();
foreach ($pengeluaran_kategori_list as $index => $l) {
    $total_kategori_pengeluaran += (double) $l['total_keluar'];
    
    $slice = true;
    $selected = true;
    
    if($index > 0){        
        $selected = false;
    }
    
    $row = array(
        "name" => $l['nama_kategori'],
        "y" => (double) $l['total_keluar'],
        "slice" => $slice, 
        "selected" => $selected
    );
    
    $donut_kategori_pengeluaran[] = $row;
    
    $count = $index + 1;
    if($count == $max_pengeluaran_kategori_list) break;
}

// set spline 
$spline_total_per_day = array();
$spline_total_per_day['total_masuk'] = array();
$spline_total_per_day['total_keluar'] = array();
$categories = array();
if(isset($total_per_day_for_current_month) && count($total_per_day_for_current_month) > 0){    
    foreach ($total_per_day_for_current_month as $day => $l) {
        $total_masuk = 0;
        $total_keluar = 0;
        if(isset($l['total_masuk'])){
            $total_masuk = (double)$l['total_masuk'];
        }
        if(isset($l['total_keluar'])){
            $total_keluar = (double)$l['total_keluar'];
        }
        $spline_total_per_day['total_masuk'][] = $total_masuk;        
        $spline_total_per_day['total_keluar'][] = $total_keluar;  
        $categories[] = "$day " . date('M');
    }
}
?>
<html>
    <head>        
        <?php view('templates/meta') ?>
        <?php view('templates/style') ?>
        <?php view('templates/script') ?>    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.3/highcharts.js"></script>
        <!--<script src="<?php echo site_url('assets/highcharts/highcharts-3d.js')?>"></script>-->
        <!--<script src="<?php echo site_url('assets/highcharts/modules/exporting.js')?>"></script>-->
    </head>
    <body class="hold-transition <?= APP_SKIN ?> sidebar-mini">     
        <?php view('templates/header') ?>
        <?php view('templates/sidebar') ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->            
            <section class="content">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?php
                                if(isset($total_transaction)){
                                    echo $total_transaction;
                                }else{
                                    echo "0";
                                }
                                ?></h3>
                                <p>Transaksi bulan ini</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-dollar"></i>
                            </div>
                            <a class="small-box-footer"></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?= count($tabungan_list) ?></h3>
                                <p>Tabungan</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-bank"></i>
                            </div>
                            <a class="small-box-footer"></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="small-box bg-olive">
                            <div class="inner">
                                <h3><?= count($pemasukkan_kategori_list) ?></h3>
                                <p>Kategori Pemasukkan</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-arrow-down"></i>
                            </div>
                            <a class="small-box-footer"></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="small-box bg-maroon">
                            <div class="inner">
                                <h3><?= count($pengeluaran_kategori_list) ?></h3>
                                <p>Kategori Pengeluaran</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-arrow-up"></i>
                            </div>
                            <a class="small-box-footer"></a>
                        </div>
                    </div>
                </div>
                <div class="row">                    
                    
                    <!--Saldo berdasarkan daftar Tabungan-->
                    
                    <div class="col-md-8">
                        <div class="box box-primary">
                            <div class="box-header with-border" style="background-color: #f5f5f5">
                                <h4 class="box-title">Grafik alur kas bulan ini, <?= date('F Y') ?></h4>
                            </div>
                            <div class="box-body">
                                <div id="container-spline-current-month" style="height: 300px"></div>
                            </div>
                            <div class="box-footer" style="background-color: #9CCC65;color: #fff">
<!--                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <h4>Saldo</h4>
                                    </div>
                                    <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                        <h4>Rp. <?= number_format($saldo, 0, ",", ".") ?></h4>
                                    </div>
                                </div>-->
                            </div>     
                        </div>                        
                    </div>
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border" style="background-color: #f5f5f5">
                                <h4 class="box-title">Saldo sampai hari ini, <?= date('d F Y') ?></h4>
                            </div>
                            <div class="box-body">
                                <?php
                                $saldo = 0;
                                $i=0;
                                foreach ($saldo_tabungan_list as $l) {
                                ?>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <h4><?= $l['nama_tabungan'] ?></h4>
                                    </div>
                                    <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                        <h4>Rp. <?= number_format((double)$l['saldo'], 0, ",", ".") ?></h4>
                                    </div>
                                </div>
                                <?php
                                    $i++;
                                    if( $i != count($saldo_tabungan_list)){
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <hr style="border-top-color: #ddd;margin-top: 5px;margin-bottom: 5px">
                                    </div>
                                </div>
                                <?php
                                    }
                                    $saldo += (double)$l['saldo'];
                                }
                                ?>                                                           
                            </div>
                            <div class="box-footer" style="background-color: #9CCC65;color: #fff">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <h4>Saldo</h4>
                                    </div>
                                    <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                        <h4>Rp. <?= number_format($saldo, 0, ",", ".") ?></h4>
                                    </div>
                                </div>
                            </div>     
                        </div>                        
                    </div>
                    
                    <?php /*
                    <!--TRANSAKSI BULAN INI-->                                        
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border" style="background-color: #f5f5f5">
                                        <h4 class="box-title">Transaksi Bulan ini, <?= date('F Y') ?></h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-6">
                                                <h4>Total Pemasukkan</h4>
                                            </div>
                                            <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                                <h4>Rp. <?= number_format((double)0, 0, ",", ".") ?></h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-6">
                                                <h4>Total Pengeluaran</h4>
                                            </div>
                                            <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                                <h4>Rp. <?= number_format((double)0, 0, ",", ".") ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row hidden">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border" style="background-color: #f5f5f5">
                                        <?php
                                        $current_month = (int)date('m');
                                        $current_year = (int)date('Y');
                                        $prev_month = $current_month - 1;
                                        $prev_year = $current_year;                                                                                
                                        
                                        if($current_month == 1) {
                                            $prev_month = 12;
                                            $prev_year = $current_year - 1;
                                        }
                                        
                                        $month = str_pad($prev_month, 2, "0", STR_PAD_LEFT);
                                        ?>
                                        <h4 class="box-title">Transaksi Bulan lalu, <?= date('F Y', strtotime($prev_year . '-' . $month . '-01')) ?></h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-6">
                                                <h4>Total Pemasukkan</h4>
                                            </div>
                                            <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                                <h4>Rp. <?= number_format((double)0, 0, ",", ".") ?></h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-6">
                                                <h4>Total Pengeluaran</h4>
                                            </div>
                                            <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                                <h4>Rp. <?= number_format((double)0, 0, ",", ".") ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    
                    <!--TRANSAKSI BULAN KEMARIN-->                                        
                    <div class="col-md-6">                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border" style="background-color: #f5f5f5">
                                        <?php
                                        $current_month = (int)date('m');
                                        $current_year = (int)date('Y');
                                        $prev_month = $current_month - 1;
                                        $prev_year = $current_year;                                                                                
                                        
                                        if($current_month == 1) {
                                            $prev_month = 12;
                                            $prev_year = $current_year - 1;
                                        }
                                        
                                        $month = str_pad($prev_month, 2, "0", STR_PAD_LEFT);
                                        ?>
                                        <h4 class="box-title">Transaksi Bulan lalu, <?= date('F Y', strtotime($prev_year . '-' . $month . '-01')) ?></h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-6">
                                                <h4>Total Pemasukkan</h4>
                                            </div>
                                            <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                                <h4>Rp. <?= number_format((double)0, 0, ",", ".") ?></h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-6">
                                                <h4>Total Pengeluaran</h4>
                                            </div>
                                            <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                                <h4>Rp. <?= number_format((double)0, 0, ",", ".") ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                     * 
                     */?>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border" style="background-color: #f5f5f5">                                
                                <h4 class="box-title"><?= $max_pemasukkan_kategori_list ?> Kategori pemasukkan terbanyak bulan ini</h4>
                            </div>
                            <div class="box-body">
                                <div id="container-kategori-pemasukan"></div>
                            </div>
                            <div class="box-footer" style="background-color: #9CCC65;color: #fff">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <h4>Total</h4>
                                    </div>
                                    <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                        <h4>Rp. <?= number_format($total_kategori_pemasukan, 0, ",", ".") ?></h4>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border" style="background-color: #f5f5f5">                                
                                <h4 class="box-title"><?= $max_pengeluaran_kategori_list ?> Kategori pengeluaran terbanyak bulan ini</h4>
                            </div>
                            <div class="box-body">
                                <div id="container-kategori-pengeluaran" style="width: 100%"></div>
                            </div>
                            <div class="box-footer" style="background-color: #9CCC65;color: #fff">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <h4>Total</h4>
                                    </div>
                                    <div class="col-sm-6 col-xs-6" style="text-align: right">                                
                                        <h4>Rp. <?= number_format($total_kategori_pengeluaran, 0, ",", ".") ?></h4>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </section>
        </div>
                
        <script>
            $(document).ready(function(){
                // set kategori pemasukan
                Highcharts.chart('container-kategori-pemasukan', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>Rp. {point.y:,.0f}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: <br/><b>Rp. {point.y:,.0f}</b>'
                            }
                        }
                    },                   
                    credits: {
                        enabled: false
                    },
                    series: [{
                        type: 'pie',
                        name: 'Total',
                        data: <?= json_encode($donut_kategori_pemasukan) ?>
                    }]
                });
                
                // set kategori pengeluaran
                Highcharts.chart('container-kategori-pengeluaran', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>Rp. {point.y:,.0f}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: <br/><b>Rp. {point.y:,.0f}</b>'
                            }
                        }
                    },                   
                    credits: {
                        enabled: false
                    },
                    series: [{
                        type: 'pie',
                        name: 'Total',
                        data: <?= json_encode($donut_kategori_pengeluaran) ?>
                    }]
                });
                
                Highcharts.chart('container-spline-current-month', {
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: ''
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: <?= json_encode($categories) ?>
                    },
                    yAxis: {
                        title: {
                            text: 'Jumlah (Rp.)'
                        },
                        labels: {
                            format: 'Rp. {value}'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' ',
                        valuePrefix: "Rp. "
                    },
                    plotOptions: {
                        spline: {
                            lineWidth: 4,
                            states: {
                                hover: {
                                    lineWidth: 5
                                }
                            }
                        }
                    },                   
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Total masuk',
                        color: '#9CCC65',
                        data: <?= json_encode($spline_total_per_day['total_masuk']) ?>

                    }, {
                        name: 'Total keluar',
                        color: '#ff3823',
                        data: <?= json_encode($spline_total_per_day['total_keluar']) ?>
                    }],
                    navigation: {
                        menuItemStyle: {
                            fontSize: '10px'
                        }
                    }
                });
            });                        
        </script>
        <?php view('templates/footer') ?>
    </body>
</html>