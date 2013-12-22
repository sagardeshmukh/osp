<h1>New help category</h1>

<form action="<?php echo url_for("help_category/create")?>" method="POST">
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="<?php echo __('Save') ?>" />
</form>