<?php if($pager->getNbResults()):?>
<table cellspacing="1" cellpadding="3" border="0" class="table-list-view">
  <tr class="list-title">
    <td style="text-align: left;">&nbsp;</td>
    <td style="text-align: left;"><a href="#"><?php echo __('Title') ?></a></td>
    <td style="text-align: left;"><a href="#"><?php echo __('Viewed') ?></a></td>
    <td style="text-align: left;"><a href="#"><?php echo __('Added') ?></a></td>
    
    <?php if ($status == 1):?>
    <td style="text-align: left;"><a href="#"><?php echo __('Finish') ?></a></td>
    <?php endif?>
    <td width="60" style="text-align: left;">#</td>
  </tr>
    <?php foreach($pager->getResults() as $i => $product):?>
      <?php include_partial('listItem', array('product' => $product, 'i' => $i, 'status' => $status));?>
    <?php endforeach;?>
</table>

<div class="pagenav">
  <div class="pagenavWrap">
      <?php echo js_pager_navigation($pager, url_for("manageProduct/myProduct")."?status=".$status."&divId=".$divId, $divId)?>
  </div>
</div>
<?php endif?>