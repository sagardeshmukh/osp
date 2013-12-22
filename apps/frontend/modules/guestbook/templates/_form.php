<form  class="flash_notice" id="guestbook_form" action="<?php echo url_for('guestbook/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post">
<table>
  <?php echo $form ?>
</table>
    <div align="center">
        <input type="submit" value="<?php echo __('Send') ?>" onclick="submitComment(); return false"/>
        <input type="submit" value="<?php echo __('Cancel') ?>" onclick="jQuery('#guestbook_form_container').dialog('close'); return false;" />
    </div>
</form>