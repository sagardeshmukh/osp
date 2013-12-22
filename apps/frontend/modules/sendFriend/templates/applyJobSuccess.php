<div class="bread-crumb"> <a href="<?php echo url_for('@homepage')?>" class="home" style="z-index:100;"></a>
  <?php $z_index = 100;?>
  <?php foreach($parent_categories as $parent_category): $z_index--?>
  <?php
        if ($parent_category->getParentId() == 0)
        {
            echo link_to($parent_category->getName(), '@category_home?categoryId='.$parent_category->getId().'&xType='.$categoryType, array("style" => "z-index:{$z_index}"));
        } else
        {
            echo link_to($parent_category->getName(), '@product_browse?categoryId='.$parent_category->getId().'&xType='.$categoryType, array("style" => "z-index:{$z_index}"));
        }
        ?>
  <?php endforeach;?>
</div>
<?php  if ($sf_user->getFlash('message')) {
  ?>
	  <div id="messages">
	  <div class="success"><?php echo $sf_user->getFlash('message'); ?></div>
	  </div>
  <?php
  } ?>
<div class="boxHeader">
  <div>
    <h3><?php echo __('Apply now for ').$product->getName()?></h3>
  </div>
</div>

<div class="boxContent">
  <div class="boxWrap">
  
    <form class="flash_notice" id="sendFriend_form" name="sendFriend_form" action="" method="post" enctype="multipart/form-data">
  <table class="add-detail">
      <?php echo $form->renderHiddenFields(false) ?>
      <?php if(isset($product_id)): ?>
      <input type="hidden" name="p_id" value="<?php echo $product_id ?>"/>
      <?php endif; ?>
      <?php echo $form?>
  </table>
  <div align="center" style="margin-top: 10px; margin-left: 80px;">
      <span class="button">
          <a href="#" class="gray" onclick="#"><span><?php echo __('Cancel') ?></span></a>
      </span>

      <span class="button">
          <a class="blue" href="#" style="margin-left: 10px;" onclick="document['sendFriend_form'].submit();return false"><span><?php echo __('Send') ?></span></a>
      </span>
  </div>

    <div class="clear"></div>
  </div>
</div>
<div class="boxFooter">
  <div></div>
</div>
<div class="clear">&nbsp;</div>
