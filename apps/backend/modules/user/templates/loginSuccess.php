<form action="<?php echo url_for("user/login")?>" method="POST">
  <table>
    <?php echo $form ?>
    <tr>
       <td></td>
       <td><input type="submit" value="<?php echo __('Login') ?>" /></td>
    </tr>
  </table>
  
</form>