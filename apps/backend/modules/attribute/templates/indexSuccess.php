<br />
<label for="category_id">Category:</label>
<?php 
$categories = Doctrine::getTable('Category')->getParentCategoryOptions(0);
$categoryWidget  = new sfWidgetFormChoice(array('choices' => $categories));
echo $categoryWidget->render('category_id', $sf_request->getParameter('category_id'), array('style' => 'width: 500px;'));
?>
<br />
<h1>Attributes List</h1>
<table>
  <thead>
    <tr class="header">
      <td>Name</td>
      <td>Type</td>
      <td>Is main</td>
      <td>Is column</td>
      <td>Is filterable</td>
      <td>Required</td>
	  <td>Collapse</td>
	  <td>Is map</td>
      <td>Sort order</td>
      <td>#</td>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($attributes as $attribute): ?>
    <tr>
      <td>
        <?php echo $attribute->getName() ?>
        <input type="hidden" value="<?php echo $attribute->getId() ?>" name="attr_ids[]" />
      </td>
      <td><?php echo $attribute->getType() ?></td>
      <td><?php if ($attribute->getIsMain()) echo image_tag('icons/checked.png') ?></td>
      <td><?php if ($attribute->getIsColumn()) echo image_tag('icons/checked.png') ?></td>
      <td><?php if ($attribute->getIsFilterable()) echo image_tag('icons/checked.png') ?></td>
      <td><?php if ($attribute->getIsRequired()) echo image_tag('icons/checked.png') ?></td>
	  <td><?php if ($attribute->getIsMain()) echo link_to($attribute->getIsCollapse()?"Yes" : "No", 'attribute/editCollapse?id='.$attribute->getId()."&is_collapse=".$attribute->getIsCollapse(), array('class' => 'editCollapse', 'confirm' => 'Are you sure to change the status?')) ?></td>
	  <td><?php echo link_to($attribute->getIsMap()?"yes" : "No", 'attribute/editIsMap?id='.$attribute->getId()."&is_map=".$attribute->getIsMap(), array('class' => 'editIsMap', 'confirm' => 'Are you sure to change the status?')) ?></td>
      <td><?php echo $attribute->getSortOrder() ?></td>
      <td class="action" nowrap>
          <?php echo link_to(image_tag('icons/edit.png'), 'attribute/edit?id='.$attribute->getId(), array('class' => 'edit'))?>
          <?php echo link_to(image_tag('icons/cross.png'), 'attribute/delete?id='.$attribute->getId(), array('class' => 'delete', 'confirm' => 'Are you sure?'))?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script type="text/javascript">
  $('#category_id').bind('change', function(){
    window.location = '<?php echo url_for("attribute/index")?>'+'?category_id='+$(this).val();
  });

  $(function() {
    $("tbody").sortable({
      stop: function(event, ui) {
        var ids = ui.item.parent().children('tr').children('td').children('input').map(function(){
          return $(this).val();
        }).get().join(",");
        $.ajax({
          url: "<?php echo url_for("attribute/sort")?>",
          type : "post",
          data: {ids : ids}
        });
      }
    });
  });
</script>

