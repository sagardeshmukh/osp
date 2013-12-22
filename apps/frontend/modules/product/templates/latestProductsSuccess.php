<h1>Latest Products</h1>
<table cellspacing="0" cellpadding="0" border="0" class="table-list-view">
  <?php foreach ($products as $product): $i++; ?>
    <tr class="<?php echo ($i % 2 == 0) ? "even" : "odd" ?>">
      <td align="center" width="80">
      <?php echo link_to(image_tag($product->getImagePath("t_")), 'product_show', $product, array('target' => '_blank')) ?>
    </td>
    <td>
      <a target="_blank" href="<?php echo url_for('product_show', $product) ?>"><?php echo strlen($product->getName()) > 50 ? myTools::utf8_substr($product->getName(), 0, 50) . '..' : $product->getName() ?></a>
      <br/>
      <div class="price" style="color:#999"><?php echo $product->getPrice($sf_user->getPreffCurrency()) ?></div>
    </td>
  </tr>
  <?php endforeach; ?>
</table>