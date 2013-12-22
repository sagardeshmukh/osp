<?php include_partial("mail/header");?>

<p style="font-family:Arial;margin-bottom:16px;">
  "<?php echo $product->getName()?>" <?php echo __('named product you have inserted has been put in yozoa.com for'); ?> <?php echo $days ?>  <?php echo __('days left') ?>.
  <?php echo __('Recently openned') ?> <?php echo $product->getReadCount()?> <?php echo __('times') ?>.<br/>
  <?php echo __('Link') ?>: <a href="<?php echo url_for('product_show', $product, true)?>">http://www.yozoa.com/p/<?php echo $product->getId()?></a>
  
  <br/><br/>
  
  <b><?php echo __('What will we do now') ?></b><br/>
 - <?php echo __('You can'); ?> <a href="http://yozoa.mn/manageProduct/myProduct"> <?php echo __('extend') ?> </a>.<br/>
 - <?php echo __('You can'); ?> <a href="#"><?php echo __('share') ?></a><br/>
 - <?php echo __('You can'); ?> <a href="http://www.yozoa.mn/manageProduct/addDoping/id/<?php echo $product->getId()?>"><?php echo __('advertise') ?></a><br/>
 - <?php echo __('If it sold, you can'); ?> <a href="http://yozoa.mn/manageProduct/myProduct"><?php echo __('delete') ?></a><br/>
 - <?php echo __('You can add new product'); ?> <a href="http://yozoa.mn/manageProduct/step1"><?php echo __('insert'); ?></a>
 
  <br/><br/>
  
  <?php echo __('Good luck'); ?>
</p>

<?php include_partial("mail/footer");?>