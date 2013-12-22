<?php include_partial("mail/header");?>

<p style="font-family:Arial;margin-bottom:16px;">
 <a href="biznetwork.mn/p/<?php echo  $username?>"><?php echo $username ;?></a> user answered question of your <?php echo $productName ?> named product.<br/>
  <?php echo __('Do you want to read click') ?> <a href="http://www.yozoa.mn/p/<?php echo $productId?>#answer"><?php echo __('here') ?></a>.
</p>
   <?php echo __('Good luck') ?>
<?php include_partial("mail/footer");?>