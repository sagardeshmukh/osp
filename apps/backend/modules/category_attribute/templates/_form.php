<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('category_attribute/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?category_id='.$form->getObject()->getCategoryId().'&attribute_id='.$form->getObject()->getAttributeId() : '')) ?>" method="post" id="category_attribute_form" onsubmit="return addCategory()" class="jNice">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="<?php echo __('Add') ?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <td>
          <?php echo $form['category_id']->renderLabel() ?>
        </td>
        <td>
          <?php echo $form->renderGlobalErrors() ?>
          <?php echo $form['category_id']->renderError() ?>
          <?php echo $form['category_id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
