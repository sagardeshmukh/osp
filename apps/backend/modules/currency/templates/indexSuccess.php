<h3>Currency</h3>
<form action="<?php echo url_for('currency/update') ?>" id="currency_form">
  <table border="1">
    <tr>
      <td><h3>Code</h3></td>
      <td><h3>Name</h3></td>
      <td><h3>Value</h3></td>
      <td>#</td>
    </tr>
    <?php foreach ($currencies as $currency): ?>
      <tr>
        <td><?php echo $currency->getCode() ?></td>
        <td><?php echo $currency->getName() ?></td>
        <td>
           <?php if ($currency->getCode() != "USD"):?>
           <input type="text" value="<?php echo $currency->getValue() ?>" id="value_<?php echo $currency->getCode() ?>" name="value[<?php echo $currency->getCode() ?>]" />
           <?php else:?>
           <?php echo $currency->getValue() ?>
           <?php endif?>
        </td>
        <td><?php echo link_to_unless($currency->getCode() == 'USD', image_tag('/images/icons/edit.png'), 'currency/addEdit?code=' . $currency->getCode()) ?></td>
      </tr>
    <?php endforeach; ?>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" onclick="fetchData(); return false;" value="Fetch data from xe.com" />
        </td>
        <td colspan="2">
          <input type="submit" onclick="saveAll(); return false;" value="Save" />
        </td>
      </tr>
    </table>
  </form>

  <script type="text/javascript">
    function saveAll(){
      $.ajax({
        url : '<?php echo url_for('currency/saveAll') ?>',
        data: $('#currency_form').serialize(),
        success : function(){
          alert('Successfully saved');
        }
      });
    }
    function fetchData(){
      $.ajax({
        url : '<?php echo url_for('currency/fetchDataXe') ?>',
      dataType: 'json',
      success: function(data){
        $.each(data, function(index, value) {
          $('#value_' + value.code).val(value.value);
        });
      }
    });
  }
</script>