<?php use_helper('Text');?>
<tr class="<?php if ($product->hasDoping(myConstants::$DIFFERENT)) echo "featured"?>">

  <td align="center" width="80">

    <?php echo link_to(image_tag($product->getImagePath("t_")), 'product_show', $product)?>

  </td>

  <td>

    <a href="<?php echo url_for('product_show', $product)?>"><div align="justify" style="height:50px;"><?php echo truncate_text(getProductName($product, $sf_user->getCulture()),'60','..')?></div></a>

    <p class="compare-hide" style="display: none;">

      <input id="compare_id_<?php echo $product->getId()?>" class="compare-select" type="checkbox" name="compareId[]" value="<?php echo $product->getId()?>" />

      <label for="compare_id_<?php echo $product->getId()?>"><?php echo __('Compare') ?></label>

      <?php echo image_tag($product->getImagePath("t_"), 'style=display:none;');?>

    </p>

  </td>

  <td class="price" align="center" nowrap><?php echo $product->getPrice($sf_user->getPreffCurrency())?></td>

  <td class="date" align="center"><?php echo substr($product->getConfirmedAt(), 0, 10)?></td>

</tr>