<?php include_partial('bread_crumb', array(
                'title' => 'Select Category',
                'current'=>1,
                'checked'=> 0,
                )) ?>

<div class="box boxGray">
  <div class="boxHeader"><div><h3><?php echo __('Select category') ?></h3></div></div>
  <div class="boxContent">
    <div id="categorydiv">
      <div id="category_box_div">
        <div id="category">
          <?php
          $is_leaf  = false;
          if (sizeof($categories))
          {
            foreach($categories as $i => $category)
            {
              include_partial('category', array('categories' => $category_table->getChildren($category->getParentId(), false, 0, $sf_user->getCulture()), 'selected_id' => $category->getId()));
              if ($category->isLeaf())
              {
                $is_leaf = true;
              }
            }
          }
          else
          {
            include_partial('category', array('categories' => $category_table->getChildren(0, false, 1, $sf_user->getCulture()), 'selected_id' => 0));
          }
          ?>
          <div class="continue-button <?php echo $is_leaf ? 'enabled-button' : 'disabled-button';?>">
            <div class="text"><?php echo __('Continue') ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div><!--box-->

<input type="hidden" name="unique_id" id="unique_id" value="<?php echo $unique_id?>" />

<script type="text/javascript">
  jQuery(document).ready(function(){
    var width = 0;
    $('#category div').each(function(index){
      width += $(this).outerWidth(true);
    });
    $('#category').css({width: width });
    $('#category_box_div').animate({scrollLeft: width}, 800);
    $('.continue-button').click(function(){
      if ($(this).hasClass('enabled-button')) {
        window.location = '<?php echo url_for('manageProduct/step2')?>?unique_id=<?php echo $unique_id?>'
      }
    });
  });
  function changeCategory(element, id, isLeaf)
  {
    $('.continue-button').removeClass('disabled-button enabled-button');
    $(element).parents('div:first').nextAll('.progressive').remove();
    
    if(!$("#category").data('loading'))
    {
      $(element).parents('div:first').find("a").removeClass("link-click");
      $(element).addClass("link-click");
      
      if (isLeaf == true)
      {
        $('.continue-button').addClass('enabled-button');
        $.ajax({
          url: "<?php echo url_for('manageProduct/selectLeafCategory')?>",
          type: "post",
          data: {id : id, unique_id : $("#unique_id").val() }
        });
      } else {
        $('.continue-button').addClass('disabled-button');
        $("#category").data('loading', true);
        $(element).append('<img style="float: right;" src="/images/step1-loading.gif">');
        $.ajax({
          url: "<?php echo url_for('manageProduct/showChildCategory')?>",
          type: "post",
          data: {id : id, unique_id : $("#unique_id").val() },
          success: function(data){
            $(element).find('img').remove();
            $("#category").data('loading', false);
            $('.progressive:last').after(data);
            var width = 0;
            $('#category div').each(function(index){
              width += $(this).outerWidth(true);
            });
            $('#category').css({width: width});
            $('#category_box_div').animate({scrollLeft: width}, 800);
          }});
      }
    }
    return false;
  }
</script>