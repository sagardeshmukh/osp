<?php

//product attributes

$mainProductAttributes = $product->getProductAttributes(1, $sf_user->getCulture());

$optionalProductAttributes = $product->getProductAttributes(0, $sf_user->getCulture());

//product images

$productImages = $product->getProductImages();

$image = unserialize($product->getImage());

$parent_categories = Doctrine::getTable('Category')->getParentCategories($product->getCategoryId(), false, $sf_user->getCulture())

?>



<div class="bread-crumb">

  <a href="<?php echo url_for('@homepage') ?>" class="home" style="z-index:100;"></a>

  <?php

  $z_index = 100;

  foreach ($parent_categories as $parent_category) {

    if ($parent_category->getId() > 0) {

      $z_index--;

      if (in_array($parent_category->getId(), array_keys(myConstants::getCategoryTypes()))) {

        echo link_to($parent_category->getName(), '@category_home?&xType=' . $product->getCategoryType() . "/", array("style" => "z-index:{$z_index}"));

      } else {

        echo link_to($parent_category->getName(), '@product_browse?categoryId=' . $parent_category->getId() . '&xType=' . $product->getCategoryType(), array("style" => "z-index:{$z_index}"));

      }

    }

  }

  ?>

</div>
<div>

<div class="box info-container product-view inline left">
 
  <?php

  $xType = $product->getCategoryType();
  
  if($xType != 'realestates' && $xType != 'cars' && $xType != 'rental') { ?>
  <div class="boxHeader boxNoTitle"><div></div></div>
  <?php
  }
  switch ($xType)

  {

    case 'jobs':

      include_partial('product/jobDetail', array(

        'mainProductAttributes' => $mainProductAttributes,

        'product' => $product,

      ));

      break;

    case 'products':

      include_partial('product/defaultDetail', array(

        'mainProductAttributes' => $mainProductAttributes,

        'product' => $product,

        'productImages' => $productImages,

      ));

      break;

    case 'realestates':

      include_partial('product/realEstateDetail', array(

        'mainProductAttributes' => $mainProductAttributes,

        'product' => $product,

        'productImages' => $productImages,

      ));

      break;

   case 'rental':

      /*include_partial('product/defaultDetail', array(

        'mainProductAttributes' => $mainProductAttributes,

        'product' => $product,

        'productImages' => $productImages,

      ));*/
	  include_partial('product/carDetail', array( // LNA default=>car

        'mainProductAttributes' => $mainProductAttributes,

        'product' => $product,

        'productImages' => $productImages,
		
		'optionalProductAttributes' => $optionalProductAttributes,

      ));


      break;

   case 'cars':

      include_partial('product/carDetail', array( // LNA default=>car

        'mainProductAttributes' => $mainProductAttributes,

        'product' => $product,

        'productImages' => $productImages,
		
		'optionalProductAttributes' => $optionalProductAttributes,

      ));

      break;

  case 'service':

      include_partial('product/serviceDetail', array(

        'mainProductAttributes' => $mainProductAttributes,

        'product' => $product,

        'productImages' => $productImages,

      ));

      break;

  default:

      include_partial('product/defaultDetail', array(

        'mainProductAttributes' => $mainProductAttributes,

        'product' => $product,

        'productImages' => $productImages,

      ));

      break;

  }

  ?>



    <?php if ($optionalProductAttributes && $xType != 'cars'): ?>
	<div style="width:73%;">
    <div class="boxHeader"><div><h3><?php echo __('Additional information') ?></h3></div></div>

    <div class="boxContent">

      <div class="boxWrap">

        <?php foreach ($optionalProductAttributes as $productAttribute): ?>

        <div class="detail">

          <h6 class="detail-header"><?php echo $productAttribute->getAttributeName() ?></h6>

            <?php if (in_array($productAttribute->getType(), array("textbox", "textarea"))): ?>

            <div class="d"><?php echo $productAttribute->getAttributeValue(); ?></div>

            <?php elseif ($productAttribute->getType() == "selectbox"): ?>

            <div class="d"><?php echo join(", ", $productAttribute->getProductAttributeValues(false, $sf_user->getCulture())) ?></div>

            <?php else: ?>

              <?php foreach ($productAttribute->getProductAttributeValues(true, $sf_user->getCulture()) as $a_value): ?>

              <div class="d"><strong class="<?php echo $a_value->getChecked() ? "highlight" : "" ?>"><?php echo $a_value ?></strong></div>

              <?php endforeach; ?>

              <div class="clear"></div>

            <?php endif ?>

        </div>

        <?php endforeach ?>

        <div class="clear"></div>

      </div>

    </div>

    <div class="boxFooter"><div></div></div>
	</div>
    <?php endif ?>

</div>

   <?php if($xType != 'jobs' && $xType != 'realestates' && $xType != 'cars'): ?>

    <div id="comment" style="width:73%;">

      <?php include_component('product', 'comments', array('productId' => $product->getId(), 'comment_error' => 1)) ?>

    </div>

   <?php endif; ?>

<!--</div>--><!--box-->

<?php

  switch ($xType)

  {

    case 'jobs':

	  include_partial('product/jobInfo', array('product' => $product));

      break;

    case 'rental':

      include_partial('product/realEstateContact', array('product' => $product));

      break;

    default:

      //include_partial('product/salesman', array('product' => $product));

  }

?>


</div>
<br clear="all">

<script type="text/javascript">

  $(document).ready(function(){

    $("a[rel='colorbox']").colorbox({width:820, height:540});

  });

</script>

