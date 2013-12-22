<form  class="flash_notice" id="agreement_form" action="<?php echo url_for('manageProduct/addAgreement') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<table>
  <?php echo $form ?>
</table>
    <div align="center">
        <input type="submit" value="<?php echo __('Send') ?>" />
        <input type="submit" value="<?php echo __('Cancel') ?>" onclick="jQuery('#agreement_form_container').dialog('close'); return false;" />
    </div>
</form>

<script type="text/javascript">
$('#agreement_form').ajaxForm({
        beforeSubmit: function(a,f,o) {
            o.dataType = 'html';
        },
        success: function(data) {
            jQuery("#agreement_form_container").html(data);
        }
    });

</script>