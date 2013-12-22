<div class="bread-crumb">
  <a href="<?php echo url_for('@homepage')?>" class="home" style="z-index:100;"></a>
  <?php $z_index = 100;?>
  <?php
  foreach($parent_categories as $parent_category){
    if ($parent_category->getId() > 0){
       $categoryName = $parent_category->getName();
       $categoryType = $products[0]->getCategoryType();
       $z_index--;
       if (in_array($parent_category->getId(), array_keys(myConstants::getCategoryTypes()))){
         echo link_to($categoryName, '@category_home?xType='.$categoryType . "/", array("style" => "z-index:{$z_index}")); // LNA add / to link
       } else {
         echo link_to($categoryName, '@product_browse?categoryId='.$parent_category->getId().'&xType='.$categoryType, array("style" => "z-index:{$z_index}"));
       }
    }
  }?>
</div>

<?php $per_column = (int) (100 / (count($products) + 1)) ?>
<div class="box clear">
  <div class="boxHeader"><div><h3><?php echo __('Compare products') ?></h3></div></div>
  <div class="boxContent">
    <div class="boxWrap">
      <table cellspacing="1" cellpadding="1" border="0" class="table-list-view">
        <tr class="compare-title">
          <td><?php echo __('Products') ?></td>
          <?php foreach($products as $product):?>
          <td width="<?php echo $per_column?>%">
              <?php include_partial('compareItem', array('product' => $product))?>
          </td>
          <?php endforeach?>
        </tr>
        <?php foreach($attributes as $attribute):?>
        <?php if ($attribute->getId() == 98) continue;?>
        <tr>
          <th><?php echo $attribute->getName()?></th>
            <?php foreach($productAttributes as $productAttribute):?>
          <td>
                <?php if (isset($productAttribute[$attribute->getId()])):?>
                  <?php
                  if ($productAttribute[$attribute->getId()]->getType() == "textbox" || $productAttribute[$attribute->getId()]->getType() == "textarea")
                  {
                    echo $productAttribute[$attribute->getId()]->getAttributeValue();
                  }
                  else
                  {
                    echo join(", ", $productAttribute[$attribute->getId()]->getProductAttributeValues(false));
                  }?>
                <?php endif?>
          </td>
            <?php endforeach?>
        </tr>
        <?php endforeach?>
      </table>
      <div class="clear"></div>
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div><!--box-->


<div id="dialog" title="<?php echo __('Add my basket') ?>"></div>

<script type="text/javascript">
  $(document).ready( function() {
    $('table.table-list-view tr:even').addClass('even');
    $('table.table-list-view tr:odd').addClass('odd');
    $('#dialog').dialog({
      autoOpen: false,
      width: 200,
      buttons: { "Ok": function() {
          $.ajax({
            url : "/shopping/addProductToBasket",
            dataType: "json",
            data : $("#amount_form").serialize(),
            success: function(data){
              $("#"+data.update).html(data.content);
              if (data.error == 0){
                $('#dialog').dialog("close");
              }
            }
          });
        }
      }
    });
  });
  function addToBasket(productId){
    $.ajax({
      url  : '/shopping/addToCart',
      data : { product_id : productId},
      success: function(data){
        $("#dialog").html('<p>'+data+'</p>');
        $('#dialog').dialog('open');
      }
    });
  }
</script>