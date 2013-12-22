<br/>
<form action="<?php echo url_for('product/update');?>" method="post" name="product" id="product" >
    <input type="hidden" value="<?php echo $id ?>" name="ssss"/>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="<?php echo __('Save')?>"  />
        </td>
      </tr>
    </tfoot>
    <tbody>
       <tr>
        <td>Name:</td>
        <td><input name="name" type="text" value="<?php echo $product->getName()?>" /></td>
      </tr>
       <tr>
        <td>Description:</td>
        <td><textarea name="description" cols="80" rows="5" type="text" id="description"><?php echo $product->getDescription()?></textarea></td>
      </tr>
       <tr>
        <td>Price</td>
        <td>
          <input name="price_original" type="text" value="<?php echo $product->getPriceOriginal()?>" />
          <?php $selectField = new sfWidgetFormChoice(array('choices' => CurrencyTable::getInstance()->getCurrOptions()));?>
          <label>Currency</label>
          <?php echo $selectField->render('currency_main', $product->getCurrencyMain())?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
<script type="text/javascript">
    $(document).ready(function(){
    var niceEditArea = new nicEditor({fullPanel : true}).panelInstance('description')});
</script>
