<?php include_partial('bread_crumb', array(
                        'title' => 'Insert '.$xType,
                        'xType' => $xType,
                        'current' => 3,
                        'checked' => 3
                        )) ?>

<div class="box boxGray">
  <div class="boxHeader boxNoTitle"><div></div></div>
  <div class="boxContent">
    <div class="boxWrap">
      <div class="actions">
        <span class="button"><a title="<?php echo __('Back') ?>" class="gray" href="<?php echo url_for('manageProduct/step2')?>?unique_id=<?php echo $unique_id?>"><span><?php echo __('Back') ?></span></a></span>
        <span class="button"><a title="<?php echo __('Continue') ?>" class="blue" href="<?php echo url_for('manageProduct/step5')?>?unique_id=<?php echo $unique_id?>"><span><?php echo __('Continue') ?></span></a></span>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>

<?php include_partial('product/show', array(
        'product' => $product,
	    'sf_cache_key' => $product->getCacheKey() . $sf_user->getCulture()))?>

<div class="box boxGray">
  <div class="boxHeader boxNoTitle"><div></div></div>
  <div class="boxContent">
    <div class="boxWrap">
      <div class="actions">
        <span class="button"><a title="<?php echo __('Edit') ?>" class="gray" href="<?php echo url_for('manageProduct/step2')?>?unique_id=<?php echo $unique_id?>"><span><?php echo __('Edit') ?></span></a></span>
        <span class="button"><a title="<?php echo __('Continue') ?>" class="blue" href="<?php echo url_for('manageProduct/step5')?>?unique_id=<?php echo $unique_id?>"><span><?php echo __('Continue') ?></span></a></span>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>