<?php use_helper('Text');?>
<div class="item<?php if ($product->hasDoping(myConstants::$DIFFERENT))

  echo " featured" ?>">

  <div class="wrap">

    <div class="image">

<?php echo link_to(image_tag($product->getImagePath("s_"), array("width" => 150)), 'product_show', $product) ?>

    </div>

    <div class="info">

      <h3>

        <a href="<?php echo url_for('product_show', $product) ?>"><div align="justify" style="height:50px;"><?php echo truncate_text(getProductName($product, $sf_user->getCulture()),'60','..') ?></div></a>

      </h3>

      <p class="price"><?php echo $product->getPrice($sf_user->getPreffCurrency()) ?></p>

      <p class="compare-hide" style="display: none;">

        <input id="compare_id_<?php echo $product->getId() ?>" class="compare-select" type="checkbox" name="compareId[]" value="<?php echo $product->getId() ?>" />

        <label for="compare_id_<?php echo $product->getId() ?>"><?php echo __('Compare') ?></label>

<?php echo image_tag($product->getImagePath("t_"), 'style=display:none;'); ?>

      </p>

      <ul>

        <li><?php echo __('Time left') ?>: <?php echo date('Y-m-d', strtotime($product->getConfirmedAt())) ?></li>

        <li>

          <?php

          $salesMan = $product->getUser();

          echo link_to($salesMan->getInitial() . "." . $salesMan->getFirstname(), '@product_browse?userId=' . $product->getUserId().'&xType='.$product->getCategoryType());

          ?>

        </li>

      </ul>

    </div>

    <div class="clear"></div>

  </div>

</div>

