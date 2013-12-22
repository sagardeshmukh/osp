<?php include_partial("mail/header");?>

<p style="font-family:Arial;margin-bottom:16px;">
  <?php echo __('Your store has been activated successfully') ?>.
  <br/>
  <?php echo __('Link') ?>: <a href="http://<?php echo $alias?>.yozoa.com">http://<?php echo $alias?>.yozoa.com</a>
</p>

<?php include_partial("mail/footer");?>