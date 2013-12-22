<table>
  <thead>
    <tr class="header">
      <td>Category</td>
      <td>X area</td>
      <td>Price original</td>
      <td>Price global</td>
      <td>Description</td>
      <td>#</td>
    </tr>
  </thead>
  <tbody id="CategoryItems">
    <?php foreach ($price_formats as $price_format): ?>
    <tr>
      <td><?php echo $price_format->getCategory() ?></td>
      <td><?php echo $price_format->getXArea() ?></td>
      <td><?php echo $price_format->getPriceOriginal() ?></td>
      <td><?php echo $price_format->getPriceGlobal() ?></td>
      <td><?php echo $price_format->getDescription() ?></td>
      <td class="action" nowrap>
          <?php echo link_to(image_tag('icons/edit.png'), 'priceFormat/edit?id='.$price_format->getId(), array('class' => 'edit'))?>
          <?php echo link_to(image_tag('icons/cross.png'), 'priceFormat/delete?id='.$price_format->getId(), array('class' => 'delete', 'confirm' => 'Are you sure?'))?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>