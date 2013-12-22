<fieldset>
  <legend>Edit Attribute</legend>
  <?php include_partial('form', array('form' => $form , 'subcat_ids' => $subcat_ids , 'subcat' => $subcat)) ?>
</fieldset>
<?php
  $type = $form->getObject()->getType();
  $attribute_id = $form->getObject()->getId();
?>

<?php if ($type != 'textarea' && $type != 'textbox'): ?>
    <fieldset>
      <legend>Attribute values</legend>
      <input type="submit" value="sort by alpha" onclick="alphaSort(); return false;" />
      <div id="attribute_value_list">
    <?php include_component('attribute_values', 'list', array('attribute_id' => $attribute_id)) ?>
      </div>
      <hr />
      <textarea id="attrValueText"></textarea>
      <button type="submit" onclick="parseAttrValues(); return false;"><span><span>Add Values</span></span></button>
</fieldset>
<?php endif ?>

    <!--<fieldset>
      <legend>Category Attribute</legend>
      <div id="category_attribute_list">
    <?php //include_component('category_attribute', 'list', array('attribute_id' => $attribute_id)) ?>
  </div>
</fieldset>-->

<script type="text/javascript">
  $(document).ready( function() {
	$(function () { // this line makes sure this code runs on page load
		$('.checkall').click(function () {
			$(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
		});
	});   
  });
  function parseAttrValues()
  {
    $.ajax({
      url: '<?php echo url_for("attribute_values/addValues") ?>',
      data : {'values[]' : $.grep($("#attrValueText").val().split("\n"), function(itm){
          return !/^\s*$/.test(itm);
        }), 'attributeId' : '<?php echo $attribute_id ?>' },
      type: 'post',
      dataType: 'json',
      success : function(data){ location.reload();
        /*$("#attrValueText").val("");
        $("#" + data.update).html(data.content);
        $("#" + data.update + ' > form').jNice();
        $("#sortable").sortable({ stop: function() { sortValues(); } });
        $("#sortable").disableSelection(); */
      }
    });
  }
  function alphaSort()
  {
    var mylist = $('#sortable');
    var listitems = mylist.children('li').get();
    listitems.sort(function(a, b) {
      var compA = $(a).text().toUpperCase();
      var compB = $(b).text().toUpperCase();
      return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
    })
    $.each(listitems, function(idx, itm) { 
      mylist.append(itm);
    });
    sortValues();
  }
  function sortValues()
  {
    var ids = $("#sortable li :input").map(function(){
      return $(this).val();
    }).get().join(",");
    $.ajax({
      url: "<?php echo url_for("attribute_values/sort") ?>",
      type : "post",
      data: {ids : ids}
    });
  }
  $(function() {
    $("#sortable").sortable({ stop: function() { sortValues(); } });
    $("#sortable").disableSelection();    
  });
  function addValue()
  {
    $.ajax({
      url: "<?php echo url_for("attribute_values/create") ?>",
      type : "post",
      data: $("#att_val_form").serialize(),
      dataType: "json",
      success: function(data){ location.reload();
        /*$("#" + data.update).html(data.content);
        $("#" + data.update + ' > form').jNice();
        $("#sortable").sortable({ stop: function() { sortValues(); } });
        $("#sortable").disableSelection();*/
      }
    });
    return false;
  }

  function deleteSelectedValue()
  { 
  	var data = '';
	var value = '';
    $(':checkbox:checked').each(function(i){
	  value = $(this).attr("id");
	  if(isNumeric(value)){
	  if(data == '')
	  	data = value;
	  else
	  	data = data+","+value;
	  }
    }); 
	if(data != ''){
		if(window.confirm('Are you sure?'))
		{
		  $.ajax({
			url: "<?php echo url_for("attribute_values/deleteMultipleAttributeValues") ?>",
			type: "post",
			data: {str : data},
			success: function(e){
			  location.reload();
			}
		  });
		}
	}
    return false;
  }
  
  function isNumeric(value) {
	  if (value == null || !value.toString().match(/^[-]?\d*\.?\d*$/)) return false;
	  return true;
  }
  
  function deleteValue(element, id)
  {
    if(window.confirm('Are you sure?'))
    {
      $.ajax({
        url: "<?php echo url_for("attribute_values/delete") ?>",
        type: "post",
        data: {id : id},
        success: function(){
          $(element).parents('li:first').remove();
        }
      });
    }
    return false;
  }

  function addCategory()
  {
    $.ajax({
      url: "<?php echo url_for("category_attribute/create") ?>",
      type : "post",
      data: $("#category_attribute_form").serialize(),
      dataType: "json",
      success: function(data){
        $("#" + data.update).html(data.content);
        $("#" + data.update + ' > form').jNice();
      }
    });
    return false;
  }
  function deleteCategory(element, category_id, attribute_id)
  {
    if(window.confirm('Are you sure?'))
    {
      $.ajax({
        url: "<?php echo url_for("category_attribute/delete") ?>",
        type: "post",
        data: {category_id : category_id, attribute_id : attribute_id},
        success: function(){
          $(element).parents('tr:first').remove();
          window.location.reload();
        }
      });
    }
    return false;
  }

  /*
  $(document).ready(function(){
    $('#att_val_form').bind('submit', function(){
      addValue();
      return false;
    });
    $('#category_attribute_form').bind('submit', function(){
      addCategory();
      return false;
    })
  });
   */
</script>