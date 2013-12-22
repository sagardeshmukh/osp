<div class="compare-item">
  <div class="wrap">
    <div class="image">
      <?php echo link_to(image_tag($product->getImagePath("s_"), array("width" => 150)), 'product_show', $product)?>
    </div>
    <div class="info">
      <h3>
        <a href="<?php echo url_for('product_show', $product)?>"><?php echo getProductName($product,$sf_user->getCulture())?></a>
      </h3>
      <div class="price"><?php echo $product->getPrice($sf_user->getPreffCurrency())?></div>
    </div>
  </div>
</div>