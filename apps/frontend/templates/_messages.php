<div id="messages">
  <!-- message boxes -->
  <!--  ajiluulj chadsangui.  -->
  <?php if(isset($form) && ( $form->hasErrors() || $form->hasGlobalErrors()) ) : ?>
  <div class="error">
    <b><?php echo __('Error has occurred') ?>:</b>
    <br /> &nbsp; <br />
      <?php foreach( $form->getGlobalErrors() as $name => $error ) : ?>
    &nbsp; - <?php echo $error ?><br />
      <?php endforeach ?>
      <?php $errors = $form->getErrorSchema()->getErrors() ?>
      <?php if ( count($errors) > 0 ) : ?>
        <?php foreach( $errors as $name => $error ) : ?>
    &nbsp; - <?php echo $error ?><br />
        <?php endforeach ?>
      <?php endif ?>
  </div>
  <?php endif ?>

  <?php if ($sf_user->hasFlash('success')): ?>
  <div class="success"><?php echo $sf_user->getFlash('success')?></div>
  <?php endif; ?>

  <?php if ($sf_user->hasFlash('info')): ?>
  <div class="info"><?php echo $sf_user->getFlash('info')?></div>
  <?php endif; ?>

  <?php if ($sf_user->hasFlash('warning')): ?>
  <div class="warning"><?php echo $sf_user->getFlash('warning')?></div>
  <?php endif; ?>

  <?php if ($sf_user->hasFlash('error')): ?>
  <div class="error"><?php echo $sf_user->getFlash('error')?></div>
  <?php endif; ?>
</div>