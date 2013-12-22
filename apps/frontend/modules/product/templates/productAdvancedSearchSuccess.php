<?php
function print_category($parent_id, $level, $nested_categories)
{
  $i=0; foreach($nested_categories[$parent_id] as $category)
  {
      if($i>=8){
          echo "</ul><ul style=\"float: left;\">";
          $i=0;
      }

      echo "<li><input type=\"checkbox\" name = categoryIds[] value=\"".$category->getId()."\" />".str_repeat('', $level * 7).$category->getName();


    
    echo '</li>'; $i++;
  }
}
?>

<div style="margin-bottom: 10px;">
   
<form method="post" action="<?php echo url_for('product/search')?>">
    <input type="hidden" name="xarea_id" id="xarea_id" value="" />
    <input type="hidden" name="xType" value="<?php echo $xType ?>" />
    <h1><?php echo ucfirst($xType) ?> advanced search</h1>
<div class="title">Country</div>
    <table class="joblist">
        <tbody>
            <tr>
                <td><div style="margin-left: 10px;">
                            <?php include_partial('manageProduct/childArea', array('x_areas' => $xareas, 'selected_id' => 0)); ?>
                    </div>
        </td>
            </tr>
        </tbody>
    </table>

    <div class="title">Select Category</div>
<div style="display: block; position: relative">
    <table class="joblist">
        <tbody>
            <tr>
                <td valign="top">
                <ul style="float: left;">
    <?php
    if (isset($nested_categories[$CtypeId->getId()]))
    {
      print_category($CtypeId->getId(), 0, $nested_categories);
    }
    ?>
                </ul>
        </td>
            </tr>
        </tbody>
    </table>
  
</div>

    <div class="title">Salary</div>
    <table class="joblist">
        <tbody>
            <tr>
                <td><div style="margin-left: 10px;">
                    min<input type="text" name="min" value=""/>
                    max<input type="text" name="max" value=""/>
                    </div>
        </td>
            </tr>
        </tbody>
    </table>

    <div class="title">Keyword</div>
    <table class="joblist">
        <tbody>
            <tr>
                <td>
                <input class="search_input" type="text" name="keyword"/>
                <input class="search_button" type="submit" name="submit" value="Search" />
        </td>
            </tr>
        </tbody>
    </table>
</form>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    function getChildElement(element){
      $(element).nextAll(':select').remove();
      var id = $(element).val();
      var parent= $(element).parent('div')
      $('#xarea_id').val(id);

    $.ajax({
      url : "<?php echo url_for("manageProduct/childArea")?>",
      data : { id : id },
      cache : false,
      success : function(data){
          var $response=$(data);
          $('#xarea_id').val($response.filter(':select:first').val());
          $('.product_x_area:last').after(data);
      }
    });
  }
</script>