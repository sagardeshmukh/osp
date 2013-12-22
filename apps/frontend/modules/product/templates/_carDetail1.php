<?php // LNA - 14.06.2011   ?>


<div style="float:left;width:100%;">

<div class="box info-container product-view inline left" style="width:65%">
    <div class="boxWrap">

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

                  <div class="thumb-pic"><a href="<?php echo url_for("@album?product_id=".$product->getId()) ?>"><?php echo image_tag($productImage->getFolder() . "s_" . $productImage->getFilename()) ?></a></div>

          <?php endif ?>

          <?php endforeach ?>

                  <div class="clear"></div>

                </div>

              </div>

              </div>

              <div class="clear">&nbsp;</div>





          <div class="boxHeader"><div><h3><?php echo __('Description') ?></h3></div></div>

            <div class="boxContent">

                <div class="boxWrap">

            <?php echo $product->getDescription() ?>

                    <div class="clear"></div>

                </div>

            </div>

                <div class="boxFooter"><div></div></div>

          <div class="clear">&nbsp; </div>
		  </div>
		  <div style="float:left;width:35%; margin-right:10px:" class="box info-container product-view inline left">
		  <div class="inline right cars-details">
      <div class="product-details" style="width: 240px;">
        <ul class="details" style="width:250px;padding-right:0px;">
          <li class="price"><span><?php echo __('Price') ?></span><?php echo $product->getPrice($sf_user->getPreffCurrency()) ?></li>
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
		  </div>
		  
		  </div> 