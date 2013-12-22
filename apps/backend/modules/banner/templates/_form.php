<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('banner/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" enctype="multipart/form-data">
<table>
  <?php echo $form ?>
</table>

<input type="submit" value="<?php echo __('Save') ?>" />

</form>