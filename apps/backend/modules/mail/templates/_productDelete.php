<?php include_partial("mail/header");?>

<?php $reason = returnDeleteReason($sf_params->get("reason_id"));?>

<p style="font-family:Arial;margin-bottom:16px;">
  <?php echo $reason ?>
  
  <?php if(isset($product)):?>
    <br/><br/>
    <?php echo __('Product name') ?>: <b><?php echo $product->getName()?></b>
  <?php endif;?>
</p>

<?php include_partial("mail/footer");?>