<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php echo $mystr123."<br> Hello How r u?";
?>
<?php //echo form_tag('') ?>
<form action="" method="post">
<input type="text" name="user" />
Name : 
<?php /*echo input_tag('name', 'default value');  */?>
<br>
city : 
<?php /*echo input_tag('ct', 'default value'); */?>
<br>
Age :
<?php /*echo input_tag('age', 'default value'); */?>
<br>
<?php //echo submit_tag('Save'); ?>
<input type="submit" name="Save" value="sava" />
</form>
</body>

</html>
