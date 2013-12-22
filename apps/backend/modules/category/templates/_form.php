<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<form action="<?php echo url_for('category/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> >
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
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
        <td><?php echo $form['name']->renderLabel() ?></td>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name']?>
        </td>
      </tr>

      <?php foreach($form->getI18nNameFields() as $field):?>
       <tr>
          <td><?php echo $field->renderLabel() ?></td>
          <td>
            <?php echo $field->renderError() ?>
            <?php echo $field?>
          </td>
        </tr>
      <?php endforeach;?>

      <tr>
        <td><?php echo $form['description']->renderLabel() ?></td>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description']?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['logo']->renderLabel() ?></td>
        <td>
          <?php echo $form['logo']->renderError() ?>
          <?php echo $form['logo']?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['is_visible']->renderLabel() ?></td>
        <td>
          <?php echo $form['is_visible']->renderError() ?>
          <?php echo $form['is_visible'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['is_featured']->renderLabel() ?></td>
        <td>
          <?php echo $form['is_featured']->renderError() ?>
          <?php echo $form['is_featured'] ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['parent_id']->renderLabel() ?></td>
        <td>
         <div id="categorydiv">
             <div id="chosenCategory">
                <?php if(isset($parent_id)){
                  $parent = Doctrine::getTable('Category')->find($parent_id);
                  echo $parent->getName();
                } ?>
             </div>
          <div id="category_box_div">
            <div id="category">
          <?php echo $form['parent_id']->renderError() ?>
          <?php
              $category_table = Doctrine::getTable('Category');
              $is_leaf  = false;
              if (sizeof($categories))
              {
                foreach($categories as $i => $category)
                {
                  include_partial('categoryOptions', array('categories' => $category_table->getChildren($category->getParentId(), false, 0, $sf_user->getCulture()), 'selected_id' => $category->getId()));
                  if ($category->isLeaf())
                  {
                    $is_leaf = true;
                  }
                }
              }
              else
              {
                include_partial('categoryOptions', array('categories' => $category_table->getChildren(0, false, 1, $sf_user->getCulture()), 'selected_id' => 0));
              }
              ?>
             </div>
          </div>
        </div>
        </td>
      </tr>
      <tr>
        <td><?php echo $form['sort_order']->renderLabel() ?></td>
        <td>
          <?php echo $form['sort_order']->renderError() ?>
          <?php echo $form['sort_order'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){
    var width = 0;
    $('#category div').each(function(index){
      width += $(this).outerWidth(true);
    });
    $('#category').css({width: width });
    $('#category_box_div').animate({scrollLeft: width}, 800);
  });
function getChildElement(element, id, isLeaf)
  {
    $('.continue-button').removeClass('disabled-button enabled-button');
    $(element).parents('div:first').nextAll('.progressive').remove();
    $("#chosenCategory").html("" + $(element).html());
    jQuery('#category_parent_id').val(id);

    if(!$("#category").data('loading'))
    {
      $(element).parents('div:first').find("a").removeClass("link-click");
      $(element).addClass("link-click");

      if (isLeaf == true)
      {
        
      } else {
        $('.continue-button').addClass('disabled-button');
        $("#category").data('loading', true);
        $(element).append('<img style="float: right;" src="/images/step1-loading.gif">');
        $.ajax({
          url: "<?php echo url_for('category/childCategory')?>",
          type: "post",
          data: {id : id },
          success: function(data){
            $(element).find('img').remove();
            $("#category").data('loading', false);
            $('.progressive:last').after(data);
            var width = 0;
            $('#category div').each(function(index){
              width += $(this).outerWidth(true);
            });
            $('#category').css({width: width});
            $('#category_box_div').animate({scrollLeft: width}, 600);
          }});
      }
    }
    return false;
  }
</script>
