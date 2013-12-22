<?php use_stylesheets_for_form($form) ?>

<?php use_javascripts_for_form($form) ?>



<form action="<?php echo url_for('attribute/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" class="jNice">

<?php if (!$form->getObject()->isNew()): ?>

<input type="hidden" name="sf_method" value="put" />

<?php endif; ?>

  <table id="attribute_table">

    <tfoot>

      <tr>

        <td colspan="2">

          <?php echo $form->renderHiddenFields(false) ?>

          <input type="submit" value="Save" />

        </td>

      </tr>

    </tfoot>

    <tbody>

      <?php echo $form->renderGlobalErrors() ?>



      <tr>

        <td><?php echo $form['name']->renderLabel() ?></td>

        <td>

          <?php echo $form['name']->renderError() ?>

          <?php echo $form['name'] ?>

        </td>

      </tr>

      <?php foreach($form->getI18nNameFields() as $field):?>

       <tr>

          <td><?php echo $field->renderLabel() ?></td>

          <td>

            <?php echo $field->renderError() ?>

            <?php echo $field?>

          </td>

        </tr>

      <?php endforeach;?>

      

      <tr>

        <td><?php echo $form['type']->renderLabel() ?></td>

        <td>

          <?php echo $form['type']->renderError() ?>

          <?php echo $form['type'] ?>

        </td>

      </tr>

      <tr>

        <td style="vertical-align:middle;"><?php echo $form['hint']->renderLabel() ?></td>

        <td>

          <?php echo $form['hint']->renderError() ?>

          <?php echo $form['hint'] ?>

        </td>

      </tr>



      <?php foreach($form->getI18nHelpFields() as $field):?>

       <tr>

          <td><?php echo $field->renderLabel() ?></td>

          <td>

            <?php echo $field->renderError() ?>

            <?php echo $field?>

          </td>

        </tr>

      <?php endforeach;?>

      <tr>

        <td><?php echo $form['is_main']->renderLabel() ?></td>

        <td>

          <?php echo $form['is_main']->renderError() ?>

          <?php echo $form['is_main'] ?>

        </td>

      </tr>

      <tr>

        <td><?php echo $form['is_column']->renderLabel() ?></td>

        <td>

          <?php echo $form['is_column']->renderError() ?>

          <?php echo $form['is_column'] ?>

        </td>

      </tr>

      <tr>

        <td><?php echo $form['is_filterable']->renderLabel() ?></td>

        <td>

          <?php echo $form['is_filterable']->renderError() ?>

          <?php echo $form['is_filterable'] ?>

        </td>

      </tr>

      <tr>

        <td><?php echo $form['sort_order']->renderLabel() ?></td>

        <td>

          <?php echo $form['sort_order']->renderError() ?>

          <?php echo $form['sort_order'] ?>

        </td>

      </tr>

      <tr>

        <td><?php echo $form['is_required']->renderLabel() ?></td>

        <td>

          <?php echo $form['is_required']->renderError() ?>

          <?php echo $form['is_required'] ?>

        </td>

      </tr>

      <tr>

      

      <tr>

      	<td>

        	<?php echo __("Country"); ?>

        </td>

        <td>

        	<select id="for_country">

            	<option value="0"><?php echo __("All"); ?></option>

            	<option value="1"><?php echo __("Norway"); ?></option>

            </select>

        </td>

      </tr>
	  <tr><td></td><td></td></tr>
<?php if($form->getObject()->isNew()) { ?>
	  <?php if(isset($categories)) { ?>
	  <tr id="for_category_0">
      	<td>

        	<?php echo __("Category"); ?>

        </td>
        <td id="">

        	<select id="" name="for_category" onchange="changeCategory(0,this.value)">

            <?php foreach($categories as $key=>$value) { ?>
				<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
			<?php } ?>
            </select>

        </td>
      </tr>
	  <?php }
	  } else if(isset($subcat_ids)) { // echo "count=".count($subcat_ids); exit; ?>
	  
	  <tr id="for_category_0">
      	<td>

        	<?php echo __("Category"); ?>

        </td>
        <td id="">

        	<select id="" name="for_category" onchange="changeCategory(0,this.value)">

            <?php foreach($subcat['subcat0'] as $value) { ?>
				<option value="<?php echo $value['id']; ?>" <?php echo $value['id'] == $subcat_ids['subcat0'] ? 'selected': '' ?>><?php echo $value['name']; ?></option>
			<?php } ?>
            </select>

        </td>
      </tr>	
	  
	  <?php	for($i = 1 ; $i < count($subcat_ids); $i++) { ?>
		
		<tr id="for_category_<?php echo $i; ?>">
			<td>
				Sub Category
			</td>
			<td>
				<select  name="for_category" onchange="changeCategory(<?php echo $i; ?>,this.value)" class="jNice">
				  <option value="0"> Select </option>
				  <?php foreach($subcat['subcat'.$i] as $category) { ?>
				  <option value="<?php echo $category['id']?>" <?php echo $category['id'] == $subcat_ids['subcat'.$i] ? 'selected': '' ?>><?php echo $category['name']; ?></option>
				  <?php } ?>
				</select>
			</td>
		</tr>
		<input type="hidden" name="levelCnt" id="levelCnt" value="<?php echo count($subcat_ids); ?>"  />
	  <?php } ?>
	<?php } ?>
	</tbody>

  </table>
 <input type="hidden" name="levelCnt" id="levelCnt" value="0"  />
</form>
<script type="text/javascript">
  function changeCategory( level, catID )
  {
	var trID = level;
	var level = level + 1;
	
	var levelCnt =  $('#levelCnt').val();
	levelCnt = parseInt(levelCnt) + 1;
	$('#levelCnt').val(level);
	
	if(catID != 0) {
		$.ajax({
			  url: "<?php echo url_for('attribute/new')?>",
			  type: "post",
			  data: 'cat_id='+catID+'&level='+level,
			  success: function(data){
				  for(l=level;l<levelCnt;l++)
				  {
				  	$('#for_category_'+l).remove();
				  }
				  
				  $('#levelCnt').val(levelCnt);
				  $('#for_category_'+trID).after(data);
				
			  }
		});
	} else {
	    
	}
  }
</script>
