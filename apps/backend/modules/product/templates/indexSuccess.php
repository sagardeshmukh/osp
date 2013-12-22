<br />
<form action="" method="post">
  <?php
  $categories = Doctrine::getTable('Category')->getParentCategoryOptions(0);
  $categoryWidget  = new sfWidgetFormChoice(array('choices' => $categories), array('style' => 'width:150px;'));
  ?>
  <label for="category_id"></label>
  <?php echo $categoryWidget->render('category_id', $sf_request->getParameter('category_id'));?>
  <label for="title">Product title :</label>
  <input type="text" name="title" id="title" value="<?php echo $sf_request->getParameter('title')?>" />
  <label for="id">Id :</label>
  <input type="text" name="id" id="id" value="<?php echo $sf_request->getParameter('id')?>" />
  <input type="submit" value="<?php echo __('Search')?>&raquo;" />
</form>
<br />
<table>
  <thead>
  <tr>
    <th>Id</th>
    <th>Product name</th>
    <th>Is active</th>
    <th>Created date</th>
    <th>#</th>
  </tr>
  </thead>
  <?php foreach($pager->getResults() as $product):?>
  <tr>
    <td><?php echo $product->getId()?></td>
    <td><?php echo $product->getName()?></td>
    <td><?php if ($product->getStatus() == 1){ echo image_tag('icons/checked.png');}else{echo $product->getStatus();}?></td>
    <td><?php echo $product->getCreatedAt()?></td>
    <td>
        <?php echo link_to('View', 'product/show?id='.$product->getId())?>
        <br/>
        <?php echo link_to('Add doping', 'product/addDoping?id='.$product->getId())?>
    </td>
  </tr>
  <?php endforeach;?>
</table>

<?php
if ($q_str_arr)
{
  echo  '<span>Page </span>'. pager_navigation($pager, url_for('product/index?'.join("&", $q_str_arr)));
}
else
{
  echo '<span>Page </span>'.pager_navigation($pager, url_for('product/index'));
}
?>