<h1>Edit help category</h1>
<form action="<?php echo url_for("help_category/update?id=".$sf_request->getParameter('id'))?>" method="POST">
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Save') ?>" />
</form>