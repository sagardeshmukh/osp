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
        <h3 style="width: 480px;"><?php echo __('Forgot password') ?> </h3>
        <div style="float: right"></div>
      </div>
    </div>
    <div class="boxContent">
      <div class="boxWrap">
        <form action="<?php echo url_for('user/forgotPassword') ?>" method="POST" name="forget_password" id="forget_password">
          <table>
            <!-- <tr>
      <td><?php  if ($sf_user->
            getFlash('message')) {
            ?>
            <div id="messages">
              <div class="success"><?php echo $sf_user->getFlash('message'); ?></div>
            </div>
            <?php
  } ?>
            </td>
            
            </tr>
            -->
            <tr>
              <td><?php echo $form['vUsername']->renderLabel() ?></td>
              <td><?php echo $form['vUsername'] ?></td>
              <td><?php echo $form['vUsername']->renderError() ?> <?php echo $form->renderGlobalErrors() ?></td>
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
