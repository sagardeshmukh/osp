<form action="/">
  <input type="hidden" name="unique_id" id="unique_id" value="<?php echo $unique_id?>" />
  <div id="category">
    <h4><?php echo __('Category')?></h4>
    <?php include_partial('category', array('categories' => $categories))?>
  </div>
  <br clear="all"/>
  <input type="submit" value="<?php echo __('next')?>" id="next" disabled />
</form>


<script type="text/javascript">
  function changeCategory(element, id)
  {
    $('#next').attr('disabled', true);
    $(element).parents('div:first').nextAll().remove();
    $.ajax({
      url: "<?php echo url_for('manageProduct/showChildCategory')?>",
      type: "post",
      data: {id : id, unique_id : $("#unique_id").val() },
      success: function(data){
        if (/^\s*$/.test(data)) {
          //activate next button
          $('#next').attr('disabled', false);
        } else {
          $('#category').append(data);
        }
      }});
    return false;
  }
</script>