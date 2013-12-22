<div id="sendFriend_form_container" class="sendFriend-dialog">
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
          <a href="#" class="gray" onclick="jQuery('#sendFriend_form_container').dialog('close'); return false;"><span><?php echo __('Cancel') ?></span></a>
      </span>

      <span class="button">
          <a class="blue" href="#" style="margin-left: 10px;" onclick="document['sendFriend_form'].submit();return false"><span><?php echo __('Send') ?></span></a>
      </span>
  </div>
</form>
</div>