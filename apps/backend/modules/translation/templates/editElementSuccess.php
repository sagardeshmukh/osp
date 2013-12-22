<?php
$hiddenField = new sfWidgetFormInputHidden();
$textAreaField = new sfWidgetFormTextarea();
?>
<h3>Add/Edit translation element</h3>
<form action="<?php echo url_for("translation/updateElement");?>" method="post">
<?php echo $hiddenField->render('id', $id);?>
<table border="1">
<?php if ($id):?>
  <tr>
    <td><h3><label>ID:</label></h3></td>
    <td><?php echo $id?></td>
  </tr>
<?php endif;?>
  <tr>
    <td><label>Source Text</label></td>
    <td>
      <?php echo $textAreaField->render('source', $source)?>
    </td>
  </tr>
  <?php foreach ($i18nLanguages as $sf_culture => $language):?>
  <tr>
    <td>
      <label><?php echo $language?></label>
    </td>
    <td>
      <?php echo $textAreaField->render("target[".$sf_culture."]", $messages[$sf_culture]['target'] ? $messages[$sf_culture]['target'] : $source)?>
    </td>
  </tr>
  <?php endforeach;?>
  <tr>
    <td colspan="2">
      <input type="submit" value="Save" />
      <?php echo link_to("Cancel", "translation/index")?>
    </td>
  </tr>
</table>
</form>