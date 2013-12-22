<?php include_partial("mail/header");?>

<p style="font-family:Arial;margin-bottom:16px;">
  <?php echo __(' Products') ?>: <a href="http://www.yozoa.mn/p/<?php echo $product->getId()?>"><?php echo $product->getName()?></a>
  <br />
 <?php echo __(' Code') ?>: <?php echo $eProduct->getCode()?>
</p>
   <?php echo __('Good luck') ?>
<?php include_partial("mail/footer");?>