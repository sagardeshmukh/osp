<div class="bread-crumb">
    <a href="<?php echo url_for('@homepage')?>" class="home" style="z-index:100;"></a>
    <?php $z_index = 100;?>
    <?php foreach($parent_categories as $parent_category): $z_index--?>
        <?php
        if ($parent_category->getParentId() == 0)
        {
            echo link_to($parent_category->getName(), '@category_home?categoryId='.$parent_category->getId().'&xType='.$categoryType, array("style" => "z-index:{$z_index}"));
        } else
        {
            echo link_to($parent_category->getName(), '@product_browse?categoryId='.$parent_category->getId().'&xType='.$categoryType, array("style" => "z-index:{$z_index}"));
        }
        ?>
    <?php endforeach;?>
</div>
<div class="boxHeader"><div><h3><?php echo __('Apply now for ').$product->getName()?></h3></div></div>
              <div class="boxContent">
                <div class="boxWrap">
      <?php include_partial('form', array('form' => $form, 'product_id'=>$product->getId())) ?>
                      <div class="clear"></div>
                    </div>
                  </div>
                  <div class="boxFooter"><div></div></div>
                  <div class="clear">&nbsp;</div>