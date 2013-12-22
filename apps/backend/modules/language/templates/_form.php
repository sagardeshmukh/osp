<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('language/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?culture='.$form->getObject()->getCulture() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table border="1">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <td><?php echo $form['culture']->renderLabel() ?></td>
        <td>
          <?php echo $form['culture']->renderError() ?>
          <?php echo $form['culture'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['name']->renderLabel() ?></td>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['prefferred_currency']->renderLabel() ?></td>
        <td>
          <?php echo $form['prefferred_currency']->renderError() ?>
          <?php echo $form['prefferred_currency'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
