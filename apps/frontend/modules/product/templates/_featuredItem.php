<div class="item" <?php if($is_last){echo 'style="background: none"';}?>>
    <h3>
      <a href="<?php echo url_for('product_show', $product)?>"><?php echo myTools::mb_strlen($product->getName()) > 25?myTools::utf8_substr($product->getName(), 0, 25).'...':$product->getName() ?></a>
    </h3>
  <div class="image">
    <?php echo link_to(image_tag($product->getImagePath("s_"), array("size" => '150x113')), 'product_show', $product)?>
  </div>
  <div class="info">
    <p class="price"><?php echo __('Price') ?>: <?php echo $product->getPrice($sf_user->getPreffCurrency())?> </p>
    <a href="/addToShoppingCart?id=<?php $product->getId()?>"><img src="/images/buy.png" border=0/></a>
  </div>
</div>