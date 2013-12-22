<div id="myMapDiv" style="width:330px; height:175px; overflow:hidden; border: solid thin #333300;"><div align="justify" style="width:321px; font-size:12px; padding: 0px 5px 0px 0px; height:40px;"> <center> <a class="blueSmall" href="../album/'+id+'" target="_blank"><b>'+name+'</b></a></center></div><div style="float:left; height:125px; width:160px;"><a href="../album/'+id+'" target="_blank"><img style="float: left;" src="<?php echo $img; ?>"></a></div> <div class="inline right cars-details" style=" float:right; width:165px; height:125px;"><div class="product-details" style="width: 165px; height:125px;"><ul class="details" style=" margin:0 0 0; padding: 0 0 0 0; width:165px; height:125px; border: solid thin #333300;"> <li class="price" style="font-size: 14px;"><span style="padding-top: 0px; width:85px;">Price</span>'+price+'</li><li> <span style="width:85px;">Property Type</span>'+attr1+'</li><li> <span style="width:85px;">Plot Area m&sup2;</span>'+attr2+'</li><li> <span style="width:85px;">Home Size m&sup2;</span>'+attr3+'</li> <li> <span style="width:100px;"><a>Mark as favorite</a></span></li></ul></div></div></div>

<!--<div id="myMapDiv" style="width:330px; height:175px; overflow:hidden; border: solid thin #333300;"><div align="justify" style="width:321px; font-size:12px; padding: 0px 5px 0px 0px; height:40px;"> <center> <a class="blueSmall" href="../album/'+id+'" target="_blank"><b>'+name+'</b></a></center></div><div style="float:left; height:125px; width:160px;"><a href="../album/'+id+'" target="_blank"><img style="float: left;" src="<?php echo $img; ?>"></a></div> <div class="inline right cars-details" style=" float:right; width:165px; height:125px;"><div class="product-details" style="width: 165px; height:125px;"><ul class="details" style=" margin:0 0 0; padding: 0 0 0 0; width:165px; height:125px;"> <li class="price" style="font-size: 14px;"><span style="padding-top: 0px; width:85px;">Price</span>'+price+'</li></ul><div class="clear"></div> </div></div></div>-->

<!--<div id="myMapDiv" style="width:330px; height:175px; overflow:hidden; border: solid thin #333300;"><div align="justify" style="width:321px; font-size:12px; padding: 0px 5px 0px 0px; height:40px;"> <center> <a class="blueSmall" href="../album/'+id+'" target="_blank"><b>'+name+'</b></a></center></div><div style="float:left; height:125px; width:160px;"><a href="../album/'+id+'" target="_blank"><img style="float: left;" src="'+img+'"></a></div> <div class="inline right cars-details" style=" float:right; width:165px; height:125px;"><div class="product-details" style="width: 165px; height:125px;"><ul class="details" style=" margin:0 0 0; padding: 0 0 0 0; width:165px; height:125px;"> <li class="price" style="font-size: 14px;"><span style="padding-top: 0px; width:85px;">Price</span>'+price+'</li></ul><div class="clear"></div> </div></div></div>
-->
<!--<div style="width:330px; height:175px; overflow:hidden;">
  <div align="justify" style="width:321px; font-size:12px; padding: 0px 5px 0px 0px; height:40px;">
  	<center>
			<a class="blueSmall" href="../album/<?php echo $product->getId(); ?>" target="_blank">
				<b><?php echo strlen($product->getName()) > 100 ? substr($product->getName(),0,'100')."..." : $product->getName(); ?></b>
			</a>
	</center>
  </div>
  <div style="float:left; height:125px; width:160px;">
  <a href="../album/<?php echo $product->getId(); ?>" target="_blank">
  	<img style="float: left;" src="<?php echo $img; ?>">
  </a>
  </div>
  
  <div class="inline right cars-details" style=" float:right; width:165px; height:125px;">
    <div class="product-details" style="width: 165px; height:125px;">
      <ul class="details" style=" margin:0 0 0; padding: 0 0 0 0; width:165px; height:125px;">
        <li class="price" style="font-size: 14px;"><span style="padding-top: 0px; width:85px;"><?php echo __('Price') ?></span><?php echo $product->getPrice($sf_user->getPreffCurrency()) ?></li>
        <?php
									
				$mainProductAttributes = $product->getProductAttributes(1, $sf_user->getCulture());
				//$attrArray = array("Address","Zip Code","Property Type","Tenure","Plot Area m²","Home Size m");
				$attrArray = array("175","190","171");
		?>
        <?php foreach ($mainProductAttributes as $productAttribute): ?>
        <?php 

										// LNA 15.06.2011 show only the attributes with value

									?>
        <?php if($productAttribute->getAttributeValue() != '' || join(", ", $productAttribute->getProductAttributeValues(false, $sf_user->getCulture())) != ''){ ?>
        <?php if(!in_array($productAttribute->getAttributeId(),$attrArray)) continue; ?>
		<li> <span style="width:85px;"><?php echo $productAttribute->getAttributeName() ?></span>
          <?php

											if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")

											{

											  if(strlen($productAttribute->getAttributeValue()) > 20)
											  	  echo substr($productAttribute->getAttributeValue(),'0','20');
											  else
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
    </div>
  </div>
</div>-->