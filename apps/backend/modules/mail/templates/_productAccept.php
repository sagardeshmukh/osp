<?php include_partial("mail/header");?>

<p style="font-family:Arial;margin-bottom:16px;">
  <?php echo __('Your product confirmed and added successfully.') ?>
  <br/>
  <?php if($dopingText) 
  {
    echo $dopingText;
    echo '<br/>';
  } ?>
  <?php echo __('Link') ?>: <a href="http://www.yozoa.mn/p/<?php echo $sf_params->get('id')?>">http://www.yozoa.com/p/<?php echo $sf_params->get('id')?></a>
</p>

<?php include_partial("mail/footer");?>