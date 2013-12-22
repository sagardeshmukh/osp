<h1>Help category</h1>
<table>
  <thead>
    <tr class="header">
      <td>Name</td>
      <td>Sort order</td>
      <td>Change</td>
    </tr>
  </thead>
  <tbody>
   <?php foreach($help_attributes as $help_attribute):?>
    <tr>
       <td><?php echo $help_attribute->getName()?> </td>
       <td><?php echo $help_attribute->getSort_order()?> </td>
        <td class="action" nowrap>
          <?php echo link_to(image_tag('icons/edit.png'), 'help_category/edit?id='.$help_attribute->getId(), array('class' => 'edit'))?>
          <?php echo link_to(image_tag('icons/cross.png'), 'help_category_delete', $help_attribute,
                array(
                'confirm' => 'Are you sure?',
                'method'  => 'delete'));
          ?>
        </td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>

<script type="text/javascript">
  $('#category_id').bind('change', function(){
    window.location = '<?php echo url_for("attribute/index")?>'+'?category_id='+$(this).val();
  });
</script>

