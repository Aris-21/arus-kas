<?php
$level = get_session_for_admin("level");
?>
<table class="table table-hover table-striped" id="table-transfer" style="margin: 0;border-top: 0;border-bottom: 0">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>No.</th>
            <th>No. Referensi</th>
            <th>Dari (Tabungan)</th>
            <th>Ke (Tabungan)</th>
            <th>Keterangan</th>
            <th>Jumlah</th>
            <th style="width: 80px"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        foreach ($list as $l) {
        ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= date('d F Y', strtotime($l['tanggal'])) ?></td>
            <td><?= $l['no_transfer_number_formatted'] ?></td>
            <td><?= $l['no_referensi'] ?></td>
            <td><?= $l['nama_tabungan_sumber'] ?></td>            
            <td><?= $l['nama_tabungan_tujuan'] ?></td>            
            <td><?= $l['keterangan'] ?></td>
            <td>Rp. <?= number_format((double)$l['jumlah'], 0, ",", ".") ?></td>
            <td style="width: 80px">
            <?php if($level == "Administrator"){ ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-xs btn-primary" onclick="load_transfer_detail('<?= md5($l['id']) ?>')" title="Ubah"><i class="fa fa-pencil"></i></button>
                    <button type="button" class="btn btn-xs btn-danger" onclick="delete_transfer('<?= md5($l['id']) ?>')" title="Hapus"><i class="fa fa-times"></i></button>                    
                </div>
            <?php } ?>
            </td>
        </tr>
        <?php
            $i++;
        }
        ?>
    </tbody>
</table>