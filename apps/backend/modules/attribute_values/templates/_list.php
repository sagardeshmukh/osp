<?php use_helper('JavascriptBase')?>

<ul id="sortable">
  <fieldset>
  <?php foreach ($attribute_list as $attribute_value): ?>
  <li class="ui-state-default">
    <input type="checkbox" name="<?php echo $attribute_value->getId(); ?>" id="<?php echo $attribute_value->getId(); ?>">
	<?php echo $attribute_value->getValue() ?>
    <input type="hidden" value="<?php echo $attribute_value->getId()?>" name="attribute_value_ids[]" />
    <?php echo link_to_function('Delete', "deleteValue(this, {$attribute_value->getId()})", array("style"=> 'float:right;'))?>
  </li>
  <?php endforeach; ?>
  <?php if(count($attribute_list) > 0){ ?>
  <div><input type="checkbox" class="checkall"> Check all</div>
  <?php echo link_to_function('Delete', "deleteSelectedValue()");
  		}
  ?>
  </fieldset>
</ul>
<?php include_partial('attribute_values/form', array('form' => $form));?>