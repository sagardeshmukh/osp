<?php if(!isset($selected_id)) $selected_id = 0;?>
<?php
if(count($x_areas)>0){ ?>
<select class="product_x_area" name="<?php echo isset($isXAreaLocations)?'product[x_area_location_id]':'product[x_area_id]'; ?>" onchange="getChildElement(this)" style="width:150px">

    <option value="0">---Select Location---</option>

<?php foreach($x_areas as $area): ?>
    <option <?php echo $selected_id == $area->getId() ? 'selected': '' ?> value="<?php echo $area->getId() ?>"><?php echo $area->getName() ?></option>
<?php endforeach; ?>
<?php	if(isset($isXAreaLocations)) 
			echo "<option value='-1'>other</option>";
?>
</select>
<?php //elseif($selected_id): ?>
 <?php } ?>