<?php use_javascript('ui/ui.core.min.js')?>
<?php use_javascript('ui/ui.dialog.min.js')?>
<?php use_javascript('ui/ui.draggable.min.js');?>
<?php use_javascript('imageviewer/jquery.ad-gallery.js');?>
<?php use_stylesheet('flick/jquery-ui-1.7.2.custom.css')?>
<?php use_stylesheet('imageviewer/jquery.ad-gallery.css')?>
<?php use_helper('Text');?>

</div>
<?php $xType = $product->getCategoryType(); ?>
<div class="content">
  <div class="inline left" style="width:697px;"><h1><?php echo wrap_text($product->getName(),'185',true); ?></h1></div>
  <div>
  <div class="inline left" style="width:697px;">
    <!-- picture -->
	<div id="container">
        <div id="gallery" class="ad-gallery">
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
	  <?php if(count($productImages) > 0) { ?>
	  <span class="button">
		<a class="blueSmall">
			<span><img src="/images/MapZoomInNoText.png" style="height:25px;"/></span>
		</a>
	  </span>
      <div class="clear">&nbsp;</div>
	  <?php } ?>
    <!-- end picture -->
    <!-- box -->
    <div class="box clear" style="width:700px;">
      <?php $realestate = $product->getRealEstate(); ?>
      <!-- Description -->
      <div class="boxHeader">
        <div>
          <h3><?php echo __('Description') ?></h3>
        </div>
      </div>
      <div class="boxContent">
        <div class="boxWrap">
          <!-- boxWrap -->
          <?php if($product->getDescription()): ?>
          <h3>Contents:</h3>
          <?php $_description =  $product->getDescription() ;?>
          <?php if ($_description): ?>
          <div class="pd-read-less"><?php echo substr(strip_tags($_description, '<br>'), 0, 500); ?>
            <?php if(strlen(strip_tags($_description))>500){  ?>
            <span class="pd-read-more-sign">...</span>
            <?php } ?>
          </div>
          <?php if(strlen(strip_tags($_description)) > 500){  ?>
          <div style="display:none;" class="pd-read-more"><?php echo $_description; ?></div>
          <div class="pd-controller"> <a id="pd-read-more-button" class="pd-button bold" href="javascript:;"> + <?php echo __('Read more')?></a> <a id="pd-read-less-button" class="pd-button bold" href="javascript:;" style="display:none;"> - <?php echo __('Hide')?></a> </div>
          <?php } ?>
          <?php endif; ?>
          <?php //echo $product->getDescription() ?>
          <div class="clear"></div>
          <?php endif; ?>
          <?php if($realestate->getLocation()): ?>
          <h3>Location:</h3>
          <?php echo $realestate->getLocation() ?>
          <div class="clear"></div>
          <?php endif; ?>
          <?php if($realestate->getTechnicalInformation()): ?>
          <h3>Technical information:</h3>
          <?php echo $realestate->getTechnicalInformation() ?>
          <?php endif; ?>
        </div>
        <!-- end boxWrap -->
      </div>
      <!-- end boxcontent -->
      <div class="boxFooter">
        <div></div>
      </div>
      <div class="clear">&nbsp;</div>
      <!-- end Description -->
      <?php if ($xType == 'realestates'){ ?>
      <!-- details -->
      <!-- MAP -->
      <div class="boxHeader" >
        <div>
          <h3><?php echo __('Map') ?></h3>
        </div>
      </div>
      <div class="boxContent">
        <div class="boxWrap">
          <div style="width:692px; height:340px; text-align:center;"> <img src="http://maps.google.com/maps/api/staticmap?zoom=9&size=700x340&maptype=roadmap&markers=color:blue|label:S|<?php echo $realestate->getMapLat() ?>,<?php echo $realestate->getMapLng() ?>&sensor=false" /> </div>
        </div>
      </div>
      <div class="boxFooter">
        <div></div>
      </div>
      <div class="clear">&nbsp;</div>
      <!-- end Map -->
      <!-- end details -->
      <?php } ?>
      <?php if (isset($optionalProductAttributes)): ?>
      <div class="boxHeader">
        <div>
          <h3><?php echo __('Additional information') ?></h3>
        </div>
      </div>
      <div class="boxContent">
        <?php if($xType == 'realestates') { ?>
					<div class="boxWrap" style="color:red solid 1px">
	
					<table class="tbl-info" cellspacing="2" cellpadding="2"  style="width:100%">
					<?php $i=0;				  
						foreach ($optionalProductAttributes as $productAttribute): 
						
							if (in_array($productAttribute->getType(), array("textbox", "textarea"))){ 
								$var1 = $productAttribute->getAttributeValue(); 
							} elseif ($productAttribute->getType() == "selectbox") {
								$var1 = join(", ", $productAttribute->getProductAttributeValues(false, $sf_user->getCulture()));
							} else {
								foreach ($productAttribute->getProductAttributeValues(true, $sf_user->getCulture()) as $a_value){
									 $var2 = $a_value->getChecked() ? "highlight" : "";
									 $var1 = '<strong class="'.$var2.'" >'.$a_value.'</strong>';
								} 
							} 
							
						if($i % 2 == 0) {
							echo "<tr class='' ><td>".$var1."</td><td>".$productAttribute->getAttributeName()."</td>"; 
						} else { 
							echo "<td>".$var1."</td><td>".$productAttribute->getAttributeName()."</td></tr>"; 
						}
						
						$i++;
					  ?>
					 <?php  endforeach  ;
							if($i % 2 != 0) {
								echo "<td>&nbsp;</td><td>&nbsp;</td></tr>"; 
							}
					 ?>
					 </table>		   
					  <div class="clear" ></div>
					</div>
			<?php } ?>
      </div>
      <div class="boxFooter">
        <div></div>
      </div>
      <?php endif ?>
      <div id="comment">
        <?php include_component('product', 'comments', array('productId' => $product->getId(), 'comment_error' => 1)) ?>
      </div>
      <!-- end description -->
    </div>
  </div>
  <div class="inline right">
    <?php

		// Information

        // LNA 14.06.2011

		

		// LNA 14.06.2011

		// end information

		?>
    <?php

		  if($xType == 'realestates')
		  {
			  ?>
    <div id="sendFriend_form_container" class="sendFriend-dialog"></div>
    <div id="askQuestion_form_container" class="askQuestion-dialog"></div>
    <div class="inline right cars-details">
      <div class="product-details" style="width: 270px;">
        <ul class="details">
          <li class="price" style="font-size: 14px;"><span style="padding-top: 0px;"><?php echo __('Price') ?></span><?php echo $product->getPrice($sf_user->getPreffCurrency()) ?></li>
          <?php

									$mainProductAttributes = $product->getProductAttributes(1, $sf_user->getCulture());

								?>
          <?php foreach ($mainProductAttributes as $productAttribute): ?>
          <?php 

										// LNA 15.06.2011 show only the attributes with value

									?>
          <?php if($productAttribute->getAttributeValue() != '' || join(", ", $productAttribute->getProductAttributeValues(false, $sf_user->getCulture())) != ''){ ?>
          <li> <span><?php echo $productAttribute->getAttributeName() ?></span>
            <?php

											if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")

											{

											  echo $productAttribute->getAttributeValue();

											} else

											{

											  echo join(", ", $productAttribute->getProductAttributeValues(false, $sf_user->getCulture()));

											}?>
          </li>
          <?php 

									}?>
          <?php endforeach ?>
        </ul>
        <div class="clear"></div>
        <?php $salesMan = Doctrine::getTable('User')->find($product->getUserId()); ?>
        <div class="user-information">
          <h2><?php echo __('Provider'); ?></h2>
          <div class="user-profile">
            <div class="info"> <span><a href="/user/profiles/id/<?php echo $salesMan->getId()?>" target="_blank" ><?php echo $salesMan->getInitial().".".$salesMan->getFirstname()?></a></span> </div>
          </div>
          <!--user-profile-->
          <ul class="contact-tools">
            <li><span class="name"><b><?php echo __('Phone') ?> 1:</b> <?php echo $product->getPhoneCell()?></span></li>
            <li><span class="name"><b><?php echo __('Phone') ?> 2:</b> <?php echo $product->getPhoneHome()?></span></li>
          </ul>
        </div>
        <div class="clear"></div>
        <div class="buttons">
          <?php if ($product->getBuyOnline() == 1): ?>
          <span class="button"><a href="/shopping/addProductToBasket?product_id=<?php echo $product->getId() ?>" class="yellow" title="<?php echo __('Buy') ?>" id="addToBasket"><span><?php echo __('Buy') ?> &raquo;</span></a></span>
          <?php endif; ?>
          <span class="button"> <a class="blueSmall" href="javascript:;"  onclick="AskQuestion(<?php echo $product->getId() ?>)"><span><?php echo __('Ask a question') ?></span></a> </span>
          <ul class="share">
            <li><a href="#" onClick="window.print()" class="print" title="<?php echo __('Print') ?>"><span><?php echo __('Print') ?></span></a></li>
            <li><a href="#" onclick="MailTo(<?php echo $product->getId() ?>)" class="email" title="<?php echo __('Send friends') ?>"><span><?php echo __('Send friends') ?></span></a></li>
            <li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode('http://yozoa/p/' . $product->getId()) ?>" class="facebook" title="share Facebook friends"><span>Facebook</span></a></li>
            <li><a href="http://twitter.com/home/?status=<?php echo urlencode($product->getName()) ?>:%20<?php echo urlencode('http://yozoa/p/' . $product->getId()) ?>" class="twitter"  title="share twitter"><span>Twitter</span></a></li>
          </ul>
        </div>
      </div>
      <!--product-details-->
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <?php 

				   //include_partial('product/realEstateContact', array('product' => $product));

				   

				   include_partial('product/realEstateOther', array('product' => $product)); ?>
    <div class="clear"></div>
    <?php

				//include_partial('product/realEstateOther', array('product' => $product));
		  }

		?>
  </div>
  <div class="clear"></div>
</div>
</div>
<br clear="all">
<div>
<script>

jQuery(function(){

 

	jQuery("#pd-read-more-button").click(function(){

	jQuery(".pd-read-less").hide();

	jQuery(".pd-read-more").fadeIn('slow');

	jQuery(this).hide();

	jQuery("#pd-read-less-button").show();

	

	//Recalculate Height

	var pv_height = jQuery('.product-details').height();

	jQuery('.product-banner').css('height', pv_height - 5);

	

	});

	

	jQuery("#pd-read-less-button").click(function(){

	jQuery(".pd-read-more").hide();

	jQuery(".pd-read-less").fadeIn('slow');

	jQuery(this).hide();

	jQuery("#pd-read-more-button").show();

	

	//Recalculate Height

	var pv_height = jQuery('.product-details').height();

	jQuery('.product-banner').css('height', pv_height - 5);

	

	});

 

});

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
