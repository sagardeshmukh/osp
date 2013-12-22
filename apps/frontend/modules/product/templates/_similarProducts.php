<?php if (count($products)):?>

<div class="box clear">

  <div class="boxHeader"><div><h3><?php echo __('Similar products') ?></h3></div></div>

  <div class="boxContent">

	<div class="five-col-one">

      <?php foreach($products as $product):?>

        <?php include_partial('homeItem', array('product'=>$product, 'sf_cache_key'=> $product->getCacheKey()))?>

      <?php endforeach?>

      <div class="clear"></div>

    </div><!--similar-products-->

  </div>

  <div class="boxFooter"><div></div></div>

</div><!--boxBlue-->

<?php endif?>