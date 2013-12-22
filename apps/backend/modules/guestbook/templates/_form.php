<form action="<?php echo url_for('guestbook/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post">
<table>
  <?php echo $form ?>
</table>

<input type="submit" value="<?php echo __('Save') ?>" />
</form>

<script type="text/javascript">
    $(document).ready(function(){
    var niceEditArea = new nicEditor({fullPanel : true}).panelInstance('guestbook_body')});
</script>
