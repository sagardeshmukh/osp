<?php include_partial('bread_crumb', array(
                        'title' => 'Update '.$xType,
                        'categoryType' => $xType,
                        'current' => 4,
                        'checked' => 4)) ?>


<div class="box boxGray">
  <div class="boxHeader"><div><h3><?php echo __('Your product')?> - <?php echo $product->getName()?></h3></div></div>
  <div class="boxContent">
    <div class="boxWrap">
      <h1><?php echo __('Your product added successfully.')?></h1>
      <?php echo __('Our operators check your product within <b>4 work hours</b> and make it active. So we will inform you by email.')?>
      <br/>
      <br/>
      <?php echo __('What are you going to do now?')?>
      <br/>
      <ul>
      	<li><a href="/manageProduct/step1"><?php echo __('Add new product') ?></a></li>
      	<li><a href="/manageProduct/myProduct"><?php __('Product list') ?></a></li>
      </ul>
       
    </div>
  </div>
  <div class="boxFooter"><div></div></div>
</div>