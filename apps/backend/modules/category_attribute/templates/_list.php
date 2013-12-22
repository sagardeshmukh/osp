<?php use_helper('JavascriptBase')?>
<table>
  <thead>
    <tr class="header">
      <td>Category Name</td>
      <td>#</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($category_attributes as $category_attribute): ?>
    <tr>
      <td><?php echo $category_attribute->getCategoryName()?></td>
      <td class="action"><?php echo link_to_function('delete', "deleteCategory(this, {$category_attribute->getCategoryId()}, {$category_attribute->getAttributeId()})", array('class'=> "delete"))?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('category_attribute/form', array('form' => $form));?>