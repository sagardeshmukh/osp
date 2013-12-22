<div class="item<?php if ($product->hasDoping(myConstants::$DIFFERENT)) echo " featured"?>">
  <div class="image">
    <?php echo link_to(image_tag($product->getImagePath("s_"), array('size'=>'117x88')), 'product_show', $product)?>
  </div>
  <div class="content">
     <a title="<?php echo $product->getName()?>" alt="<?php echo $product->getName()?>" href="<?php echo url_for('product_show', $product)?>" class="smaller"><?php echo myTools::mb_strlen($product->getName()) > 19?myTools::utf8_substr($product->getName(), 0, 19).'..':$product->getName() ?></a>
     <?php if($product->getBuyOnline() == 1):?>
	    <div style="margin: 3px"><img src="/images/buy.png" border="0" /></div>
     <?php endif;?>
  </div>
</div>