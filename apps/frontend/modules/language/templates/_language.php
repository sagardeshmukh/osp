<form action="<?php echo url_for('change_language') ?>">
<?php echo $form["language"]//echo $form ?>
<!--<label for="currency">Currency</label>-->
<?php $currancy = isset($_SESSION['currency'])? $_SESSION['currency'] : 'NOK';//$sf_user->getAttribute('currency', 'NOK'); ?>
<select name="currency">
<?php foreach($currency as $key => $value){ ?>
  <option value="<?php echo $key ?>" <?php echo $key == $currancy ? 'selected="selected"' : '' ?>><?php echo $value; ?></option>
<?php } ?> 
</select>
<input type="submit" value="ok" />
</form>