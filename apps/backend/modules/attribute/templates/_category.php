<?php if(count($categories)>0) { ?>
<tr id="for_category_<?php echo $level; ?>">
<td>
	Sub Category
</td>
<td>
	<select  name="for_category" onchange="changeCategory(<?php echo $level; ?>,this.value)" class="jNice">
	  <option value="0"> Select </option>
	  <?php foreach($categories as $category) { ?>
	  <option value="<?php echo $category['id']?>"><?php echo $category['name']; ?></option>
	  <?php } ?>
	</select>
</td>
</tr>
<? } ?>