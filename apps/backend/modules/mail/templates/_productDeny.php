<?php include_partial("mail/header");?>

<?php $reason = returnDenyReason($sf_params->get("reason_id"));?>

<p style="font-family:Arial;margin-bottom:16px;">
  <?php echo $reason ?>
  <br/>
  <?php echo __('If you want to edit') ?> : <a href="http://yozoa.mn/manageProduct/edit/id/<?php echo $sf_params->get('id')?>">http://yozoa.mn/manageProduct/edit/id/<?php echo $sf_params->get('id')?></a>
</p>

<?php include_partial("mail/footer");?>