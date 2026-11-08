<?php
if(isset($list) && is_array($list) && count($list) > 0){
  $i=1;
  foreach ($list as $l) {
    ?>
    <tr>
      <td class="text-right">
        <a class="text-primary" href="javascript:void(0)" onclick="load_detail('<?= md5($l["id"]) ?>')"><i class='fa fa-edit'></i></a> &nbsp;
        <a class="text-danger" href="javascript:void(0)" onclick="confirm_delete('<?= md5($l["id"]) ?>')"><i class='fa fa-trash'></i></a>
      </td>
      <td style="vertical-align: middle"><?= $i ?></td>
      <td style="vertical-align: middle"><?= $l["name"] ?></td>      
    </tr>
    <?php
    $i++;
  }
} else { 
?>
<tr>
  <td colspan="4">No Data</td>
</tr>
<?php
}