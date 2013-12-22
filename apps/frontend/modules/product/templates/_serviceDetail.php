<?php

$service = $product->getService();

$start_const = myConstants::getStartMissionType($service->getStartMission());

$end_const = myConstants::getEndMissionType($service->getEndMission());

$start_mission = $start_const ? $start_const: $service->getStartMission();

$end_mission = $end_const ? $end_const: $service->getEndMission();

?>



<div class="boxContent">

    <div class="boxWrap">

      <div class="right"><?php echo __('Yozoa code') ?>: <?php echo $product->getId() ?></div>

      <h1><?php echo $product->getName(); ?></h1>

      <div class="product-images">

        <div class="large-pic">

          <?php if ($productImages[0]): ?>

          <?php echo image_tag($product->getImagePath("m_")) ?>

          <?php else: ?>

          <?php echo image_tag($product->getImagePath("m_")) ?>

          <?php endif; ?>



            </div>

            <div class="thumbs">

          <?php foreach ($productImages as $productImage): ?>

          <?php if (is_file(sfConfig::get('sf_web_dir') . $productImage->getFolder() . $productImage->getFilename())): ?>

                  <div class="thumb-pic"><a href="<?php echo $productImage->getFolder() . $productImage->getFilename() ?>" rel="colorbox"><?php echo image_tag($productImage->getFolder() . "s_" . $productImage->getFilename()) ?></a></div>

          <?php endif ?>

          <?php endforeach ?>

                  <div class="clear"></div>

                </div>

              </div>

              <div class="product-details">



              <ul class="details">

                 <li class="price" style="font-size: 14px;"><span style="padding-top: 0px;"><?php echo __('Price') ?></span><?php echo $product->getPrice($sf_user->getPreffCurrency()) ?></li>

                 <li><span><?php echo __('Start') ?></span><?php echo $start_mission ?></li>

                 <li><span><?php echo __('Desired') ?></span><?php echo $end_mission ?></li>

                 <li><span><?php echo __('Address') ?></span><?php echo $service->getPostalCode() ?> <?php echo $service->getCity() ?></li>

                 <?php if($service->getPhone()): ?>

                 <li><span><?php echo __('Phone number') ?></span><?php echo $service->getPhone() ?></li>

                 <?php endif; ?>

                 <?php if($service->getStreet()): ?>

                 <li><span><?php echo __('Address') ?></span><?php echo $service->getStreet() ?></li>

                 <?php endif; ?>

                 

          <?php foreach ($mainProductAttributes as $productAttribute): ?>

                    <li>

                      <span><?php echo $productAttribute->getAttributeName() ?></span>

            <?php

                    if ($productAttribute->getType() == "textbox" || $productAttribute->getType() == "textarea")

                    {

                      echo $productAttribute->getAttributeValue();

                    } else

                    {

                      echo join(", ", $productAttribute->getProductAttributeValues(false, $sf_user->getCulture()));

                    } ?>

                  </li>

          <?php endforeach ?>

                    <li><span><?php echo __('Status') ?></span> <?php echo $product->getIsNew() ? "New" : "Old" ?></li>

                    <li><span><?php echo __('Available status') ?></span> <?php echo $product->getDeliveryStatus() == 1 ? __("Available") : __("To supply") ?></li>

                    <li><span><?php echo __('Delivery') ?></span> <?php echo $product->getDeliveryType() == 1 ? __("Shipping") : __("No shipping") ?></li>

                  </ul>



                  <div class="buttons">

          <?php if ($product->getBuyOnline() == 1): ?>

                      <span class="button"><a href="/shopping/addProductToBasket?product_id=<?php echo $product->getId() ?>" class="yellow" title="<?php echo __('Buy') ?>" id="addToBasket"><span><?php echo __('Buy') ?> &raquo</span></a></span>

          <?php endif; ?>

                      <span class="button">

                        <a class="blueSmall" href="javascript:;"  onclick="AskQuestion(<?php echo $product->getId() ?>)"><span><?php echo __('Ask a question') ?></span></a>

                      </span>

                      <ul class="share">

                        <li><a href="#" onClick="window.print()" class="print" title="<?php echo __('Print') ?>"><span><?php echo __('Print') ?></span></a></li>

                        <li><a href="#" onclick="MailTo(<?php echo $product->getId() ?>)" class="email" title="<?php echo __('Send friends') ?>"><span><?php echo __('Send friends') ?></span></a></li>

                        <li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode('http://yozoa/p/' . $product->getId()) ?>" class="facebook" title="share Facebook friends"><span>Facebook</span></a></li>

                        <li><a href="http://twitter.com/home/?status=<?php echo urlencode($product->getName()) ?>:%20<?php echo urlencode('http://yozoa/p/' . $product->getId()) ?>" class="twitter"  title="share twitter"><span>Twitter</span></a></li>

                      </ul>

                    </div>



                  </div><!--product-details-->

                  <div class="clear"></div>

                </div>

              </div>



            <div class="boxFooter"><div></div></div>

              <div class="clear">&nbsp;</div>





          <div class="boxHeader"><div><h3><?php echo __('Description') ?></h3></div></div>

            <div class="boxContent">

                <div class="boxWrap">

            <?php echo $product->getDescription() ?>

                    <div class="clear"></div>

                </div>

            </div>

                <div class="boxFooter"><div></div></div>

          <div class="clear">&nbsp;</div>
		  </div>
<?php 
	
	$xType = $product->getCategoryType();
	if( $xType == 'service') {  
	
		$salesMan = Doctrine::getTable('User')->find($product->getUserId()); 
	
		$categoryId = myConstants::getCategoryId($product->getCategoryType());
		
		$products = Doctrine::getTable('Product')->getUserOtherProducts($product->getUserId(), $product->getId(), $categoryId); ?>
		
		<?php  if($salesMan):?>
		
		<!--<div id="sendFriend_form_container" class="sendFriend-dialog"></div>
		
		<div id="askQuestion_form_container" class="askQuestion-dialog"></div>-->
		
		<div class="box boxSidebarYellow user-information inline right" style="width:25%;">
		
			<div class="boxHeader"><div><h3><?php echo __('Provider') ?></h3></div></div>
		
			<div class="boxContent">
		
				<div class="boxWrap">
		
					<div class="user-profile">
		
						<div class="info">
		
							<span><a href="/user/profiles/id/<?php echo $salesMan->getId()?>" target="_blank"><?php echo $salesMan->getInitial().".".$salesMan->getFirstname()?></a></span>
		
						</div>
		
					</div><!--user-profile-->
		
					<ul class="contact-tools">
		
						<li><span class="name"><b><?php echo __('Phone') ?> 1:</b>  <?php echo $product->getPhoneCell()?></span></li>
		
						<li><span class="name"><b><?php echo __('Phone') ?> 2:</b> <?php echo $product->getPhoneHome()?></span></li>
		
						<!--<li><span class="name">Fax:  <?php //echo $salesMan->getFax()?></span></li>-->
		
					</ul>
		
					<span class="button"><a class="blueSmall" href="javascript:;"  onclick="AskQuestion(<?php echo $product->getId() ?>)"><span><?php echo __('Ask a question') ?></span></a></span>
		
					<br clear="all"/>
		
					<div class="clear"></div>
		
		
		
				</div><!--boxWrap-->
		
			</div><!--boxContent-->
		
			<div class="boxFooter"><div></div></div>
		
		</div><!--box-->
		
		<?php endif; ?>
		
		
		
		<?php if (count($products)):?>
		
		<div class="box boxSidebarGrey user-information right" style="width:25%;">
		
			<div class="boxHeader"><div><h3><?php echo __('Other products') ?></h3></div></div>
		
			<div class="boxContent">
		
				<table cellspacing="0" cellpadding="0" border="0" class="table-list-view">
		
						<?php $i=0;
		
						foreach($products as $p): $i++;?>
		
					<tr class="<?php echo ($i % 2==0)? "odd":"even" ?>">
		
						<td align="center" width="80">
		
							   <?php echo link_to(image_tag($p->getImagePath("t_")), 'product_show', $p)?>
		
						</td>
		
						<td>
		
							<a href="<?php echo url_for('product_show', $p)?>"><?php echo strlen($p->getName()) > 50?myTools::utf8_substr($p->getName(), 0, 50).'..':$p->getName() ?></a>
		
							<br/>
		
							<div class="price" style="color:#999"><?php echo $p->getPrice($sf_user->getPreffCurrency())?></div>
		
						</td>
		
					</tr>
		
						<?php endforeach;?>
		
				  </table>
		
				<span style="margin-bottom:30px;padding-left:75px" href="#">
		
					<?php $salesMan= Doctrine::getTable('User')->find($product->getUserId());
		
						  echo link_to(__('Other products').' »' ,'@product_browse?userId='.$product->getUserId().'&xType='.$product->getCategoryType());
		
						   ?>
		
				</span>
		
			</div><!--boxContent-->
		
		 <div class="boxFooter"><div></div></div>
		
		</div>
		<div class="clear"></div>
		<?php endif ; ?> <div> <?php
		
 } ?>