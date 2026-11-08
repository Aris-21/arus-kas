<?php
if(isset($list) && is_array($list) && count($list) > 0)
{
  $i=1;  
  // **
  // generate top menu

  $parent_order = 0;
  foreach ($list as $p) {
    $icon = $p["icon"];
    $title = $p["title"];
    $link = $p["link"];

    $child_list = array();
    if(isset($p["child_list"]) && is_array($p["child_list"])) $child_list = $p["child_list"];

    $icon_text = "";
    if(!empty($icon_text)) $icon_text = "";
    ?>

    <tr>         
      <td style="width: 70px;border-color: #ddd; background-color: #f0f0f0" style="vertical-align: middle">

        <?php if($parent_order <= 0){ ?>
        <button type="button" disabled class="btn btn-xs btn-default"><i class='fa fa-times'></i></button>              
        <?php }else{ ?>
        <button type="button" class="btn btn-xs btn-info"  onclick="order_up('<?= md5($p["id"]) ?>')"><i class='fa fa-arrow-up'></i></button>              
        <?php } ?>

        <?php if($parent_order >= count($list) -1){ ?>
        <button type="button" disabled class="btn btn-xs btn-default"><i class='fa fa-times'></i></button>        
        <?php }else{ ?>
          <button type="button" class="btn btn-xs btn-info"onclick="order_down('<?= md5($p["id"]) ?>')"><i class='fa fa-arrow-down'></i></button>        
        <?php } ?>
      </td>

      <td style="vertical-align: middle; border-color: #ddd;background-color: #f0f0f0">
        <i class='<?= $icon ?>'></i> &nbsp; <?= $title ?> : <?= base_url($link) ?>
      </td>      

      <td style="width: 150px;border-color: #ddd; background-color: #f0f0f0">
        <button type="button" class="btn btn-xs btn-primary" onclick="load_detail('<?= md5($p["id"]) ?>')"><i class='fa fa-edit'></i>&nbsp;Edit</button>
      
        <?php if(count($child_list) == 0){ ?>        
        <button type="button" class="btn btn-xs btn-danger" onclick="confirm_delete('<?= md5($p["id"]) ?>')"><i class='fa fa-times'></i>&nbsp;Delete</button>
        <?php } ?>        
      </td>
    </tr>

    <?php    
    // ** 
    // generate sub menu
    $child_order = 0;
    foreach ($child_list as $c) {
      $icon = $c["icon"];
      $title = $c["title"];
      $link = $c["link"];
    ?>
    <tr>
      <td>        
        <?php if($child_order <= 0){ ?>
        <button type="button" disabled class="btn btn-xs btn-default btn-trans" onclick=""><i class='fa fa-times'></i></button>              
        <?php } else {?>
        <button type="button" class="btn btn-xs btn-info btn-trans" onclick="order_up('<?= md5($c["id"]) ?>')"><i class='fa fa-arrow-up'></i></button>              
        <?php } ?>

        <?php if($child_order >= count($child_list) -1){ ?>
        <button type="button" disabled class="btn btn-xs btn-default btn-trans" onclick=""><i class='fa fa-times'></i></button>        
        <?php } else { ?>
        <button type="button" class="btn btn-xs btn-info btn-trans" onclick="order_down('<?= md5($c["id"]) ?>')"><i class='fa fa-arrow-down'></i></button>        
        <?php } ?>
      </td>
      
      <td class="pl-5" style="vertical-align: middle">
        <i class='<?= $icon ?>'></i> &nbsp; <?= $title ?> : <?= base_url($link) ?>
      </td>

      <td class="">
        <button type="button" class="btn btn-xs btn-primary btn-trans" onclick="load_detail('<?= md5($c["id"]) ?>')"><i class='fa fa-edit'></i>&nbsp;Edit</button>              
        <button type="button" class="btn btn-xs btn-danger btn-trans" onclick="confirm_delete('<?= md5($c["id"]) ?>')"><i class='fa fa-times'></i>&nbsp;Delete</button>        
      </td>
    </tr>
    <?php
      $child_order++;
    }

    $i++;
    $parent_order++;
  }
} else { 
?>
<tr>
  <td colspan="4">No Data</td>
</tr>
<?php
}