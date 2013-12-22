<?php use_helper('Text');?>

<div class="bread-crumb"> <a href="<?php echo url_for('@homepage') ?>" class="home" style="z-index:100;"></a>
  <?php

	$z_index = 100;

	$i = 0;

	$count_parents = count($parent_categories);

	$j = 0;

  foreach ($parent_categories as $parent_category) {

    if ($parent_category->getId() > 0) {

		$i++;

		$z_index--;

		if (in_array($parent_category->getId(), array_keys(myConstants::getCategoryTypes()))) {

		echo link_to($parent_category->getName(), '@category_home?&xType=' . $product->getCategoryType()."/", array("style" => "z-index:{$z_index}")); // LNA add / at link

		} else {

			// LNA

			

			$j ++;

			if($j == 1) echo link_to($parent_category->getName(), '@product_browse?categoryId=' . $parent_category->getId() . '&xType=' . $product->getCategoryType(), array("style" => "z-index:{$z_index}"));

		if($i == $count_parents - 1) { ?>
  <a href="<?php echo url_for("@album?product_id=".$product->getId()) ?>" title="<?php echo $product->getName();?>"><?php echo truncate_text($product->getName(),'20','..'); ?></a>
  <?php }

		}

    }

  }

  ?>
</div>

<!--<style type="text/css">
.ad-gallery {
  width: 980px;
}
.ad-gallery .ad-image-wrapper {
  height: 600px;
}
</style>
-->
<div class="content">
  <div class="inline left" style="width:697px;">
    <h1><?php echo wrap_text($product->getName(),'185',true); ?></h1>
  </div>
  <div>
    <div class="inline left" style="width:697px;">
      <!-- picture -->
      <div id="container">
        <div id="gallery" class="ad-gallery" style="width:980px; height:480px;">
          <div class="ad-image-wrapper"> </div>
          <div class="ad-controls"> </div>
          <div class="ad-nav">
            <div class="ad-thumbs">
              <ul class="ad-thumb-list">
                <?php $i = 1;
			   		 $productImages = $product->getProductImages();
					 foreach ($productImages as $productImage) { 
					 	if (is_file(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename())) { ?>
                <li> <?php echo link_to(image_tag( $productImage->getFolder() . "t_" . $productImage->getFilename(), array('class'=>$i+1)), $productImage->getFolder().$productImage->getFilename()); 
				 				$i++; ?> </li>
                <?php  }
			    	} ?>
              </ul>
            </div>
          </div>
		</div>
      </div>
	  <div class="clear">&nbsp;</div>
	  <span class="button">
		<a class="blueSmall" href="../product/album?product_id=<?php echo $product->getId(); ?>">
			<span>Back</span>
		</a>
	  </span>
      <div class="clear">&nbsp;</div>
	  
<script type="text/javascript">	  
$(document).ready(function() {
    var galleries = $('.ad-gallery').adGallery();
	var imageCount = "<?php echo count($productImages); ?>";
	if(imageCount == 0)
	{
		$('#gallery').hide();
		$("#container").append("<img src='/images/m_default.jpg'/>");
	} else if(imageCount == 1) {
		$("div").removeClass("ad-prev");
		$("div").removeClass("ad-next");
		$("div").removeClass("ad-prev-image");
		$("div").removeClass("ad-next-image");
		$('.ad-controls').hide();
		$('.ad-nav').hide();     // hide thumbnil images if image count is 1. 
	}
});
</script>
