<form action="<?php echo url_for('help_topic/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post">
<table>
  <?php echo $form ?>
</table>

<input type="submit" value="<?php echo __('Save') ?>" />
</form>

<script type="text/javascript">
    $(document).ready(function(){
    FCKeditor.ReplaceAllTextareas('fckeditor');
    onChangeNewsType();
    initSWFupload();
    initFcbkAuto();
  });
</script>