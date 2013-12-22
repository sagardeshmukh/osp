<div class="box boxGray">
  <div class="boxHeader"><div><h3><?php echo __('Main information') ?></h3></div></div>
  <div class="boxContent">
    <div class="boxWrap">
      <form method="post" id="login_form" action="<?php echo url_for("user/login")?>">
        <input type="hidden" name="referrer" value="<?php echo $referrer?>" />
        <div class="add-detail">
          <?php echo $form->renderGlobalErrors() ?>
          <?php echo $form['username']->renderRow(); ?>
          <?php echo $form['password']->renderRow(); ?>
          <div class="clear"></div>
          <br />
        </div>
        
        <div class="actions">
          <span class="button"><a href="#" onclick="$('#login_form').submit(); return false;" class="blue" title="<?php echo __('Login') ?>"><span><?php echo __('Login') ?></span></a></span>
          <div class="clear"></div>
        </div>
      </form>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>