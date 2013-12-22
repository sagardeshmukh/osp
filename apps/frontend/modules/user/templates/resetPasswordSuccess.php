<div style="width: 100%">
  <div class="box boxGray" style="width: 52%; float: left">
    <div class="boxHeader">
      <div>
        <h3><?php echo __('Register')?></h3>
      </div>
    </div>
    <div class="boxContent">
      <div class="boxWrap">
        <div class="clear"></div>
        <b  style="margin-top: 10px; margin-bottom: 5px;">Register free with us! Then, you can:</b>
        <li style="margin-left: 20px;padding-top: 4px;">Save search</li>
        <li style="margin-left: 20px;padding-top: 6px;">Get new ads by email</li>
        <li style="margin-left: 20px;padding-top: 6px;">Save and share ads</li>
        <li style="margin-left: 20px;padding-top: 6px;">Adding ads</li>
        <div class="clear"></div>
      </div>
    </div>
    <div class="boxFooter">
      <div></div>
    </div>
  </div>
  <div class="box boxGray" style="width: 47%;  float: right">
    <div class="boxHeader">
      <div>
        <h3 style="width: 480px;"><?php echo __('Reset password') ?> </h3>
        <div style="float: right"></div>
      </div>
    </div>
    <div class="boxContent">
      <div class="boxWrap">
        <form action="<?php echo url_for('user/resetPassword') ?>" method="POST" name="reset_password" id="reset_password">
          <table>
            <tr>
              <td>User Name :</td>
              <td>&nbsp;
                <?php if($uName){ echo $uName; } ?></td>
              <td></td>
            </tr>
            <tr>
              <td><?php echo $form['password']->renderLabel() ?></td>
              <td><?php echo $form['password'] ?></td>
              <td><?php echo $form['password']->renderError() ?> <?php echo $form->renderGlobalErrors() ?>
                <input type="hidden" name="key" value="<?php echo $vKey; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $form['nPassword']->renderLabel() ?></td>
              <td><?php echo $form['nPassword'] ?></td>
              <td><?php echo $form['nPassword']->renderError() ?></td>
            </tr>
            <tr>
              <td colspan="3"><input type="submit" value="Reset Password"/>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
    <div class="boxFooter">
      <div></div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<br/>
