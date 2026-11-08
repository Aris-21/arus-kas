<?php
$level = get_session_for_admin("level");
?>
<table class="table table-hover table-striped" id="table-kategori" style="margin: 0;border-top: 0;border-bottom: 0">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Keterangan</th>
            <th>Alur Kas</th>
            <th style="text-align:right">Total</th>
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
            <td><?= trim($l['nama']) ?></td>
            <td><?= trim($l['keterangan']) ?></td>
            <td><?= trim($l['alur_kas']) ?></td>
            <td align="right"><?= number_format((double)$l['total'], 0, "," , ".") ?></td>
            <td style="width: 80px">
            <?php if($level == "Administrator"){ ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-xs btn-primary" onclick="load_kategori_detail('<?= md5($l['id']) ?>')" title="Ubah"><i class="fa fa-pencil"></i></button>
                    <button type="button" class="btn btn-xs btn-danger" onclick="delete_kategori('<?= md5($l['id']) ?>')" title="Hapus"><i class="fa fa-times"></i></button>
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