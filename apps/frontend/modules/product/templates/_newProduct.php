<div class="box clear" style="width:722px;">

  <div class="boxHeader"><div><h3><?php echo __('Last') ?><span style="float: right; color: #999; font-weight: 100;">&nbsp;<a href="<?php echo url_for('@product_browse?xType=recent_hours') ?>"><?php echo __('24 hour') ?> </a><a href="#">|</a><a href="<?php echo url_for('@product_browse?xType=recent_days') ?>"> <?php echo __('3 days') ?></a></span></h3></div></div>

  <div class="boxContent">

    <div class="scrollPane">

      <div class="five-col-one">

        <ul id="mycarousel" class="jcarousel-skin-tango">

          <?php foreach ($products as $product): ?>

            <li style="width:135px;">

              <div class="item  last-item" align="center">

                <div style=" color:#FF6803; font-weight:bold;"><?php echo __('Price') ?>: <?php echo $product->getPrice($sf_user->getPreffCurrency()) ?> </div>
				
                <div class="image">

                <?php //echo link_to(image_tag($product->getImagePath("s_"), array("size" => '117x88')), 'product_show', $product) ?>
				<?php if($product->getCategoryType() == "realestates" || $product->getCategoryType() == "cars" || $product->getCategoryType() == "rental") {  ?>	
				
                <a href="<?php echo url_for("@album?product_id=".$product->getId()) ?>" ><?php echo image_tag($product->getImagePath("s_"), array("size" => '117x88')); ?></a>

              </div>
			 		
				<a  class="smaller" href="<?php echo url_for("@album?product_id=".$product->getId())//echo url_for('product_show', $product) ?>"><?php echo myTools::mb_strlen($product->getName()) > 18 ? myTools::utf8_substr($product->getName(), 0, 18) . '...' : $product->getName() ?></a>
			 
			 <?php } else { ?>  
					
					<a href="<?php echo url_for('product_show', $product) ?>" ><?php echo image_tag($product->getImagePath("s_"), array("size" => '117x88')); ?></a>

              </div>
					
					<a href="<?php echo url_for('product_show', $product) ?>"><?php echo getProductName($product, $sf_user->getCulture())?></a> 
					
			 <?php } ?>	
              
				
            </div>

          </li>

          <?php endforeach; ?>

        </ul>

      </div><!--similar-products-->

    </div>

  </div><div class="boxFooter"><div></div></div>

</div>