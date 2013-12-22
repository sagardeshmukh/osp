<h3>Add/Edit Currency</h3>
<form id="curForm" action="<?php echo url_for('currency/save')?>">
<table border="1">
  <tr>
    <td><label for="cur_code">Code :</label></td>
    <td><input id="cur_code" type="text" name="code" value="<?php echo $currency->getCode()?>" /></td>
  </tr>
  <tr>
    <td><label for="cur_name">Name :</label></td>
    <td><input id="cur_name" type="text" name="name" value="<?php echo $currency->getName()?>" /></td>
  </tr>
  <tr>
    <td><label for="cur_symbol">Symbol :</label></td>
    <td><input id="cur_symbol" type="text" name="symbol" value="<?php echo $currency->getSymbol()?>" /></td>
  </tr>
  <tr>
    <td><label for="cur_val">Value :</label></td>
    <td><input id="cur_val" type="text" name="value" value="<?php echo $currency->getValue()?>" /></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" value="Save" onclick="validateForm(); return false;" /></td>
  </tr>
</table>
</form>

<script type="text/javascript">
  function validateForm(){
    var errMsg = "";
    if (/^\s*$/.test($('#cur_code').val())){
      errMsg += "Enter currency code \n";
    }
    if (/^\s*$/.test($('#cur_name').val())){
      errMsg += "Enter currency name \n";
    }
    if (/^\s*$/.test($('#cur_symbol').val())){
      errMsg += "Enter currency symbol \n";
    }
    if (/^\s*$/.test($('#cur_val').val())){
      errMsg += "Enter currency value \n";
    }
    if (errMsg == ""){
      $('#curForm').submit();
    } else {
      alert(errMsg);
    }
  }
</script>
