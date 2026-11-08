<?php

/*
|--------------------------------------------------------------------------
| LAPORAN ALUR KAS
| SDIT CITRA UMAT KOTA TIDORE KEPULAUAN
|--------------------------------------------------------------------------
*/

ob_start();


/*
|--------------------------------------------------------------------------
| USER SESSION
|--------------------------------------------------------------------------
*/

$user = get_session("user");

$user_name = isset($user["name"])
    ? $user["name"]
    : "-";


/*
|--------------------------------------------------------------------------
| LOAD PDF ENGINE
|--------------------------------------------------------------------------
*/

library("pdf_engine");


/*
|--------------------------------------------------------------------------
| HELPER
|--------------------------------------------------------------------------
*/

function pdf_escape($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}


function pdf_parse_date($date)
{
    if(empty($date)){
        return false;
    }

    $date = trim($date);


    /*
     * FORMAT UTAMA
     * YYYY-MM-DD
     */
    $d = DateTime::createFromFormat(
        '!Y-m-d',
        $date
    );

    if($d !== false){
        return $d->getTimestamp();
    }


    /*
     * FORMAT BOOTSTRAP DATEPICKER LAMA
     * MM/DD/YYYY
     */
    $d = DateTime::createFromFormat(
        '!m/d/Y',
        $date
    );

    if($d !== false){
        return $d->getTimestamp();
    }


    /*
     * FORMAT INDONESIA
     * DD/MM/YYYY
     */
    $d = DateTime::createFromFormat(
        '!d/m/Y',
        $date
    );

    if($d !== false){
        return $d->getTimestamp();
    }


    /*
     * FALLBACK
     */
    $timestamp = strtotime($date);

    return ($timestamp !== false)
        ? $timestamp
        : false;
}


function rupiah_pdf($number)
{
    return 'Rp ' . number_format(
        (double)$number,
        0,
        ',',
        '.'
    );
}


/*
|--------------------------------------------------------------------------
| PARAMETER TANGGAL
|--------------------------------------------------------------------------
*/

$start_date_raw = isset($_GET["start_date"])
    ? trim($_GET["start_date"])
    : '';

$end_date_raw = isset($_GET["end_date"])
    ? trim($_GET["end_date"])
    : '';


$start_timestamp = pdf_parse_date(
    $start_date_raw
);

$end_timestamp = pdf_parse_date(
    $end_date_raw
);


/*
|--------------------------------------------------------------------------
| VALIDASI TANGGAL
|--------------------------------------------------------------------------
*/

if(
    $start_timestamp === false ||
    $end_timestamp === false
){

    while(ob_get_level() > 0){
        ob_end_clean();
    }

    die(
        "Format tanggal tidak valid. "
        . "Silakan pilih kembali periode laporan."
    );
}


if($start_timestamp > $end_timestamp){

    while(ob_get_level() > 0){
        ob_end_clean();
    }

    die(
        "Tanggal awal tidak boleh lebih besar "
        . "dari tanggal akhir."
    );
}


/*
|--------------------------------------------------------------------------
| FORMAT TANGGAL
|--------------------------------------------------------------------------
*/

$start_date_title = date(
    "d-m-Y",
    $start_timestamp
);

$end_date_title = date(
    "d-m-Y",
    $end_timestamp
);


$start_date_view = date(
    "d/m/Y",
    $start_timestamp
);

$end_date_view = date(
    "d/m/Y",
    $end_timestamp
);


$saldo_date_timestamp = strtotime(
    "-1 day",
    $start_timestamp
);

$saldo_date = date(
    "d M Y",
    $saldo_date_timestamp
);


/*
|--------------------------------------------------------------------------
| HITUNG RINGKASAN
|--------------------------------------------------------------------------
*/

$saldo_awal = isset($saldo_sebelumnya)
    ? (double)$saldo_sebelumnya
    : 0;


$total_masuk = 0;
$total_keluar = 0;
$total_transaksi = 0;


if(
    isset($list) &&
    is_array($list)
){

    foreach($list as $row){

        $masuk = isset($row["jumlah_masuk"])
            ? (double)$row["jumlah_masuk"]
            : 0;

        $keluar = isset($row["jumlah_keluar"])
            ? (double)$row["jumlah_keluar"]
            : 0;


        $total_masuk += $masuk;

        $total_keluar += $keluar;

        $total_transaksi++;

    }

}


$saldo_akhir =
    $saldo_awal
    + $total_masuk
    - $total_keluar;


/*
|--------------------------------------------------------------------------
| LOGO
|--------------------------------------------------------------------------
|
| Simpan logo sekolah pada:
|
| assets/images/logo-smait-citra-kirana.png
|
*/

$logo_path = base_url(
    'assets/images/logo_sdit.png'
);


/*
|--------------------------------------------------------------------------
| MPDF
|--------------------------------------------------------------------------
*/

$pdf = new \Mpdf\Mpdf(array(

    'mode' => 'utf-8',

    'format' => 'A4-L',

    'default_font_size' => 9,

    'default_font' => 'DejaVuSans',

    'margin_left' => 10,

    'margin_right' => 10,

    'margin_top' => 36,

    'margin_bottom' => 17

));


$pdf->SetTitle(
    "Laporan Alur Kas SDIT Citra Ummat - "
    . $start_date_title
    . " s-d "
    . $end_date_title
);


$pdf->setAutoTopMargin = 'stretch';


/*
|--------------------------------------------------------------------------
| HEADER / KOP SEKOLAH
|--------------------------------------------------------------------------
*/

$pdf->SetHTMLHeader('

<table
    width="100%"
    cellspacing="0"
    cellpadding="0"
    style="
        border-bottom:3px solid #1E3A8A;
        padding-bottom:7px;
    "
>

    <tr>

        <!-- LOGO -->

        <td
            width="12%"
            valign="middle"
            style="
                text-align:center;
                padding-right:8px;
            "
        >

            <img
                src="' . $logo_path . '"
                style="
                    width:68px;
                    height:auto;
                "
            />

        </td>


        <!-- IDENTITAS SEKOLAH -->

        <td
            width="61%"
            valign="middle"
            style="
                text-align:left;
            "
        >

            <div
                style="
                    font-size:17pt;
                    font-weight:bold;
                    color:#1E3A8A;
                    letter-spacing:0.3px;
                "
            >

                SDIT CITRA UMMAT

            </div>


            <div
                style="
                    font-size:11pt;
                    font-weight:bold;
                    color:#374151;
                    margin-top:2px;
                "
            >

                KOTA TIDORE KEPULAUAN

            </div>


            <div
                style="
                    font-size:8.5pt;
                    color:#6B7280;
                    margin-top:4px;
                "
            >

                Sistem Informasi Pencatatan dan
                Pengelolaan Alur Kas

            </div>

        </td>


        <!-- INFORMASI LAPORAN -->

        <td
            width="27%"
            valign="middle"
            style="
                text-align:right;
            "
        >

            <div
                style="
                    font-size:7.5pt;
                    color:#64748B;
                    font-weight:bold;
                "
            >

                LAPORAN KEUANGAN

            </div>


            <div
                style="
                    font-size:10pt;
                    font-weight:bold;
                    color:#1E3A8A;
                    margin-top:4px;
                "
            >

                '
                . $start_date_view
                . '

                s/d

                '
                . $end_date_view
                . '

            </div>


            <div
                style="
                    font-size:7.5pt;
                    color:#94A3B8;
                    margin-top:4px;
                "
            >

                SDIT Citra Ummat

            </div>

        </td>

    </tr>

</table>

');


/*
|--------------------------------------------------------------------------
| FOOTER
|--------------------------------------------------------------------------
*/

$pdf->SetFooter('

<table
    width="100%"
    cellspacing="0"
    cellpadding="0"
    style="
        border-top:1px solid #CBD5E1;
        padding-top:5px;
        font-size:7.5pt;
        color:#64748B;
    "
>

    <tr>

        <td width="38%">

            <b>
                SDIT Citra Ummat
                Kota Tidore Kepulauan
            </b>

        </td>


        <td
            width="37%"
            style="
                text-align:center;
            "
        >

            Dicetak oleh

            <b>'
            . pdf_escape($user_name)
            . '</b>

            &nbsp; | &nbsp;

            '
            . date("d/m/Y H:i:s")
            . '

        </td>


        <td
            width="25%"
            style="
                text-align:right;
            "
        >

            Halaman

            <b>{PAGENO}</b>

            dari

            <b>{nbpg}</b>

        </td>

    </tr>

</table>

');


/*
|--------------------------------------------------------------------------
| CSS
|--------------------------------------------------------------------------
*/

$css = '

body {

    font-family: DejaVuSans;

    font-size: 9pt;

    color: #374151;

}


/* ==============================================================
   JUDUL
   ============================================================== */

.report-title {

    font-size: 15pt;

    font-weight: bold;

    color: #111827;

}


.report-subtitle {

    font-size: 8.5pt;

    color: #6B7280;

    margin-top: 2px;

}


/* ==============================================================
   PERIODE
   ============================================================== */

.period-box {

    width: 100%;

    border-collapse: collapse;

    margin-bottom: 10px;

}


.period-box td {

    padding: 7px 10px;

    background-color: #EFF6FF;

    border: 1px solid #BFDBFE;

}


.period-label {

    font-size: 7.5pt;

    color: #64748B;

}


.period-value {

    font-size: 10pt;

    font-weight: bold;

    color: #1D4ED8;

    margin-top: 3px;

}


/* ==============================================================
   SUMMARY
   ============================================================== */

.summary-table {

    width: 100%;

    border-collapse: separate;

    border-spacing: 5px;

    margin-bottom: 10px;

}


.summary-box {

    border: 1px solid #E2E8F0;

    padding: 9px 10px;

    background-color: #FFFFFF;

}


.summary-label {

    font-size: 7.5pt;

    color: #64748B;

}


.summary-value {

    font-size: 12pt;

    font-weight: bold;

    margin-top: 4px;

}


.summary-blue {

    color: #1D4ED8;

}


.summary-green {

    color: #059669;

}


.summary-red {

    color: #DC2626;

}


.summary-dark {

    color: #111827;

}


/* ==============================================================
   TABLE
   ============================================================== */

.table {

    width: 100%;

    border-collapse: collapse;

}


.table thead th {

    background-color: #1E3A8A;

    color: #FFFFFF;

    border: 1px solid #1E40AF;

    padding: 6px 4px;

    font-size: 8pt;

    font-weight: bold;

    text-align: center;

}


.table tbody td {

    border: 1px solid #E2E8F0;

    padding: 5px 4px;

    font-size: 8pt;

    vertical-align: middle;

}


.row-even td {

    background-color: #F8FAFC;

}


.row-odd td {

    background-color: #FFFFFF;

}


/* ==============================================================
   SALDO AWAL
   ============================================================== */

.saldo-awal td {

    background-color: #DBEAFE;

    color: #1E3A8A;

    font-weight: bold;

    border: 1px solid #BFDBFE;

}


/* ==============================================================
   BADGE
   ============================================================== */

.badge-masuk {

    background-color: #DCFCE7;

    color: #166534;

    font-size: 7pt;

    font-weight: bold;

    padding: 3px 6px;

}


.badge-keluar {

    background-color: #FEE2E2;

    color: #991B1B;

    font-size: 7pt;

    font-weight: bold;

    padding: 3px 6px;

}


/* ==============================================================
   MONEY
   ============================================================== */

.money {

    text-align: right;

    white-space: nowrap;

}


.money-in {

    color: #047857;

}


.money-out {

    color: #B91C1C;

}


.saldo {

    color: #111827;

    font-weight: bold;

}


/* ==============================================================
   TOTAL
   ============================================================== */

.total-row td {

    background-color: #F1F5F9;

    border-top: 2px solid #64748B;

    font-weight: bold;

    padding: 7px 4px;

}


/* ==============================================================
   UTILITY
   ============================================================== */

.text-center {

    text-align: center;

}


.text-right {

    text-align: right;

}


.text-left {

    text-align: left;

}

';


$pdf->WriteHTML(
    $css,
    1
);


/*
|--------------------------------------------------------------------------
| JUDUL LAPORAN
|--------------------------------------------------------------------------
*/

$pdf->WriteHTML('

<table
    width="100%"
    cellspacing="0"
    cellpadding="0"
    style="
        margin-bottom:8px;
    "
>

    <tr>

        <td width="65%">

            <div class="report-title">

                LAPORAN ALUR KAS

            </div>


            <div class="report-subtitle">

                SDIT Citra Ummat
                Kota Tidore Kepulauan

            </div>

        </td>


        <td
            width="35%"
            style="
                text-align:right;
            "
        >

            <div
                style="
                    font-size:7.5pt;
                    color:#64748B;
                "
            >

                JUMLAH TRANSAKSI

            </div>


            <div
                style="
                    font-size:14pt;
                    font-weight:bold;
                    color:#1E3A8A;
                "
            >

                '
                . number_format(
                    $total_transaksi,
                    0,
                    ',',
                    '.'
                )
                . '

            </div>

        </td>

    </tr>

</table>

');


/*
|--------------------------------------------------------------------------
| PERIODE
|--------------------------------------------------------------------------
*/

$pdf->WriteHTML('

<table class="period-box">

    <tr>

        <td width="33%">

            <div class="period-label">

                PERIODE AWAL

            </div>


            <div class="period-value">

                '
                . $start_date_view
                . '

            </div>

        </td>


        <td width="33%">

            <div class="period-label">

                PERIODE AKHIR

            </div>


            <div class="period-value">

                '
                . $end_date_view
                . '

            </div>

        </td>


        <td width="34%">

            <div class="period-label">

                SALDO AWAL PER

            </div>


            <div class="period-value">

                '
                . pdf_escape($saldo_date)
                . '

            </div>

        </td>

    </tr>

</table>

');


/*
|--------------------------------------------------------------------------
| RINGKASAN KEUANGAN
|--------------------------------------------------------------------------
*/

$pdf->WriteHTML('

<table
    class="summary-table"
    cellspacing="5"
>

    <tr>

        <!-- SALDO AWAL -->

        <td
            width="25%"
            class="summary-box"
        >

            <div class="summary-label">

                SALDO AWAL

            </div>


            <div
                class="
                    summary-value
                    summary-blue
                "
            >

                '
                . rupiah_pdf($saldo_awal)
                . '

            </div>

        </td>


        <!-- PEMASUKAN -->

        <td
            width="25%"
            class="summary-box"
        >

            <div class="summary-label">

                TOTAL PEMASUKAN

            </div>


            <div
                class="
                    summary-value
                    summary-green
                "
            >

                '
                . rupiah_pdf($total_masuk)
                . '

            </div>

        </td>


        <!-- PENGELUARAN -->

        <td
            width="25%"
            class="summary-box"
        >

            <div class="summary-label">

                TOTAL PENGELUARAN

            </div>


            <div
                class="
                    summary-value
                    summary-red
                "
            >

                '
                . rupiah_pdf($total_keluar)
                . '

            </div>

        </td>


        <!-- SALDO AKHIR -->

        <td
            width="25%"
            class="summary-box"
        >

            <div class="summary-label">

                SALDO AKHIR

            </div>


            <div
                class="
                    summary-value
                    summary-dark
                "
            >

                '
                . rupiah_pdf($saldo_akhir)
                . '

            </div>

        </td>

    </tr>

</table>

');


/*
|--------------------------------------------------------------------------
| HEADER TABLE
|--------------------------------------------------------------------------
*/

$pdf->WriteHTML('

<table
    class="table"
    cellspacing="0"
    cellpadding="0"
>

<thead>

<tr>

    <th width="3%">

        #

    </th>


    <th width="9%">

        No. Kas

    </th>


    <th width="8%">

        Tanggal

    </th>


    <th width="11%">

        Kategori

    </th>


    <th width="10%">

        Tabungan

    </th>


    <th width="7%">

        Alur

    </th>


    <th width="18%">

        Keterangan

    </th>


    <th width="10%">

        Masuk

    </th>


    <th width="10%">

        Keluar

    </th>


    <th width="14%">

        Saldo

    </th>

</tr>

</thead>

<tbody>

');


/*
|--------------------------------------------------------------------------
| SALDO AWAL TABLE
|--------------------------------------------------------------------------
*/

$pdf->WriteHTML('

<tr class="saldo-awal">

    <td
        colspan="9"
        style="
            text-align:right;
        "
    >

        SALDO AWAL

        &nbsp;

        <span
            style="
                font-weight:normal;
            "
        >

            sampai

            '
            . pdf_escape($saldo_date)
            . '

        </span>

    </td>


    <td
        style="
            text-align:right;
            white-space:nowrap;
        "
    >

        '
        . rupiah_pdf($saldo_awal)
        . '

    </td>

</tr>

');


/*
|--------------------------------------------------------------------------
| DATA TRANSAKSI
|--------------------------------------------------------------------------
*/

$saldo = $saldo_awal;


if(
    isset($list)
    &&
    is_array($list)
    &&
    count($list) > 0
){

    $i = 1;


    foreach($list as $l){


        /*
        |--------------------------------------------------------------------------
        | NILAI TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $masuk = isset(
            $l["jumlah_masuk"]
        )
            ? (double)$l["jumlah_masuk"]
            : 0;


        $keluar = isset(
            $l["jumlah_keluar"]
        )
            ? (double)$l["jumlah_keluar"]
            : 0;


        $alur_kas_value = isset(
            $l["alur_kas"]
        )
            ? (int)$l["alur_kas"]
            : 0;


        /*
        |--------------------------------------------------------------------------
        | SALDO BERJALAN
        |--------------------------------------------------------------------------
        */

        if($alur_kas_value === 1){

            $saldo += $masuk;

            $alur_kas = "MASUK";

            $badge_class =
                "badge-masuk";

        }else{

            $saldo -= $keluar;

            $alur_kas = "KELUAR";

            $badge_class =
                "badge-keluar";

        }


        /*
        |--------------------------------------------------------------------------
        | TABUNGAN
        |--------------------------------------------------------------------------
        */

        $nama_tabungan =
            isset($l["nama_tabungan"])
            ? pdf_escape(
                $l["nama_tabungan"]
            )
            : "-";


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $nama_kategori =
            isset($l["nama_kategori"])
            ? pdf_escape(
                $l["nama_kategori"]
            )
            : "-";


        /*
        |--------------------------------------------------------------------------
        | TRANSFER
        |--------------------------------------------------------------------------
        */

        $transfer_id =
            isset($l["transfer_id"])
            ? (int)$l["transfer_id"]
            : 0;


        if($transfer_id !== 0){

            $nama_kategori =
                "<i>Pindah Buku</i>";


            if($alur_kas_value === 0){

                $nama_tabungan =
                    "<i>Dari "
                    . $nama_tabungan
                    . "</i>";

            }


            if($alur_kas_value === 1){

                $nama_tabungan =
                    "<i>Ke "
                    . $nama_tabungan
                    . "</i>";

            }

        }


        /*
        |--------------------------------------------------------------------------
        | NOMOR KAS
        |--------------------------------------------------------------------------
        */

        $no_kas =
            isset(
                $l["no_kas_number_formatted"]
            )
            ? pdf_escape(
                $l["no_kas_number_formatted"]
            )
            : "-";


        /*
        |--------------------------------------------------------------------------
        | TANGGAL TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $tanggal_transaksi = "-";


        if(
            isset($l["tanggal"])
            &&
            !empty($l["tanggal"])
        ){

            $tanggal_timestamp =
                strtotime(
                    $l["tanggal"]
                );


            if($tanggal_timestamp !== false){

                $tanggal_transaksi =
                    date(
                        "d/m/Y",
                        $tanggal_timestamp
                    );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | KETERANGAN
        |--------------------------------------------------------------------------
        */

        $keterangan =
            isset($l["keterangan"])
            ? nl2br(
                pdf_escape(
                    $l["keterangan"]
                )
            )
            : "-";


        /*
        |--------------------------------------------------------------------------
        | ZEBRA ROW
        |--------------------------------------------------------------------------
        */

        $row_class =
            ($i % 2 == 0)
            ? "row-even"
            : "row-odd";


        /*
        |--------------------------------------------------------------------------
        | OUTPUT ROW
        |--------------------------------------------------------------------------
        */

        $pdf->WriteHTML('

<tr class="' . $row_class . '">

    <td class="text-center">

        ' . $i . '

    </td>


    <td>

        ' . $no_kas . '

    </td>


    <td class="text-center">

        ' . $tanggal_transaksi . '

    </td>


    <td>

        ' . $nama_kategori . '

    </td>


    <td>

        ' . $nama_tabungan . '

    </td>


    <td class="text-center">

        <span
            class="'
            . $badge_class
            . '"
        >

            '
            . $alur_kas
            . '

        </span>

    </td>


    <td>

        ' . $keterangan . '

    </td>


    <td
        class="
            money
            money-in
        "
    >

        '
        . rupiah_pdf($masuk)
        . '

    </td>


    <td
        class="
            money
            money-out
        "
    >

        '
        . rupiah_pdf($keluar)
        . '

    </td>


    <td
        class="
            money
            saldo
        "
    >

        '
        . rupiah_pdf($saldo)
        . '

    </td>

</tr>

');


        $i++;

    }


}else{


    /*
    |--------------------------------------------------------------------------
    | DATA KOSONG
    |--------------------------------------------------------------------------
    */

    $pdf->WriteHTML('

<tr>

    <td
        colspan="10"
        style="
            text-align:center;
            padding:15px;
            color:#64748B;
        "
    >

        Tidak ada transaksi
        pada periode yang dipilih.

    </td>

</tr>

');

}


/*
|--------------------------------------------------------------------------
| TOTAL
|--------------------------------------------------------------------------
*/

$pdf->WriteHTML('

<tr class="total-row">

    <td
        colspan="7"
        style="
            text-align:right;
        "
    >

        TOTAL PERIODE

    </td>


    <td
        style="
            text-align:right;
            color:#047857;
            white-space:nowrap;
        "
    >

        '
        . rupiah_pdf($total_masuk)
        . '

    </td>


    <td
        style="
            text-align:right;
            color:#B91C1C;
            white-space:nowrap;
        "
    >

        '
        . rupiah_pdf($total_keluar)
        . '

    </td>


    <td
        style="
            text-align:right;
            color:#111827;
            white-space:nowrap;
        "
    >

        '
        . rupiah_pdf($saldo_akhir)
        . '

    </td>

</tr>


</tbody>

</table>

');


/*
|--------------------------------------------------------------------------
| INFORMASI LAPORAN
|--------------------------------------------------------------------------
*/

$pdf->WriteHTML('

<table
    width="100%"
    cellspacing="0"
    cellpadding="0"
    style="
        margin-top:10px;
        border-top:1px solid #E2E8F0;
    "
>

    <tr>

        <td
            width="70%"
            style="
                padding-top:6px;
                font-size:7.5pt;
                color:#64748B;
            "
        >

            <b>Informasi:</b>

            Saldo akhir dihitung dari saldo awal
            ditambah total pemasukan dan dikurangi
            total pengeluaran selama periode laporan.

        </td>


        <td
            width="30%"
            style="
                padding-top:6px;
                text-align:right;
                font-size:7.5pt;
                color:#64748B;
            "
        >

            Total transaksi:

            <b>
                '
                . number_format(
                    $total_transaksi,
                    0,
                    ',',
                    '.'
                )
                . '
            </b>

        </td>

    </tr>

</table>

');


/*
|--------------------------------------------------------------------------
| CLEAN OUTPUT BUFFER
|--------------------------------------------------------------------------
*/

while(ob_get_level() > 0){

    ob_end_clean();

}


/*
|--------------------------------------------------------------------------
| OUTPUT PDF
|--------------------------------------------------------------------------
*/

$pdf->Output(

    'laporan_alur_kas_smait_citra_kirana_'
    . $start_date_title
    . '_sd_'
    . $end_date_title
    . '.pdf',

    'I'

);

exit;

?>