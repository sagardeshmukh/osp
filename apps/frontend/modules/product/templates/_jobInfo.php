<?php

    $job = $product->getJob();

?>



<div class=" cars-details inline right job-info" style="width: 25%;">

	<div class="product-details" style="width: 246px;">  <!-- style="width: 246px;"-->

		<ul class="details" style="margin:5px;padding:0;margin-bottom:20px;">

			<?php // LNA set deadline ?>

        	<?php $deadline = date('Y/m/d', strtotime($product->getConfirmedAt()) + $product->getDuration() * 86400); ?> 

            <li><span><?php echo __('Deadline') ?></span><?php echo $deadline ?></li>

            <li><span><?php echo __('Company') ?></span><?php echo $job->getCompanyName() ?></li>

            <li><span><?php echo __('Location') ?></span>

            <?php echo $job->getLocation() ?>

             <?php $job_area = Doctrine::getTable('XArea')->getParents($product->getXAreaId()) ?>

             <?php if($job_area): ?>

             <br/><span>&nbsp;</span>

                 <?php echo $job_area ?>

              <?php endif ?>

            </li>

            <?php if($job->getHomepage()): ?>

            <li><span><?php echo __('Website') ?></span><?php echo link_to('click here', $job->getHomepage(), array('target' => '_blank')) ?></li>

            <?php endif; ?>

            

            <?php $mainProductAttributes = $product->getProductAttributes(1, $sf_user->getCulture());?>	

            <?php foreach ($mainProductAttributes as $productAttribute): ?>

			<?php if($productAttribute->getAttributeValue() != '' || join(", ", $productAttribute->getProductAttributeValues(false, $sf_user->getCulture())) != ''){ ?>

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

            <?php } ?>    

            <?php endforeach ?>

		</ul>

            <?php if($job->getCName1() || $job->getCName2()): ?>

    	  	<h4 class="job-brief-heading"><?php echo __('Questions about the position') ?></h4>

          	<div class="job-information">	

				<!--<div class="boxWrap" style="padding:0px !important">-->

                    <ul style="margin: 8px 0;" class="details">

                      <?php if($job->getCName1()): ?>

                          <li><span><?php echo __('Contact') ?>:</span><?php echo $job->getCName1() ?></li>

                          <?php if($job->getCTitle1()): ?>

                          		<li><span><?php echo __('Title') ?>:</span><?php echo $job->getCTitle1() ?></li>

                          <?php endif; ?>

                          <?php if($job->getCPhone1() && $job->getIsPhone() == false): ?>

                          		<li><span><?php echo __('Phone') ?>:</span><?php echo $job->getCPhone1() ?></li>

                          <?php endif; ?>

                      <?php endif; ?>

                      

                      <?php if($job->getCName2()): ?>

                      	  <li><span><?php echo __('Contact') ?>:</span><?php echo $job->getCName2() ?></li>

						  <?php if($job->getCTitle2()): ?>

                          	<li><span><?php echo __('Title') ?>:</span><?php echo $job->getCTitle2() ?></li>

                          <?php endif; ?>

                          <?php if($job->getCPhone2() && $job->getIsPhone() == false): ?>

                          	<li><span><?php echo __('Phone') ?>:</span><?php echo $job->getCPhone2() ?></li>

                      	  <?php endif; ?>

                      <?php endif; ?>

                    </ul>

                    

    			<!--</div>-->

            </div>

     	<?php endif; ?>

		<div class="clear"></div>	

		<div class="job-information job-email">	

			<div class="boxWrap" style="padding:0px !important">

            	<ul>

                	<?php

						if($job->getContact()){

						?>

                        <li><span><?php echo __('Email') ?>:</span>

                        	<span class="button"><a class="blueSmall" href="<?php echo url_for('sendFriend/contact?p_id='.$product->getId()) ?>"><span><?php echo __('Apply job') ?></span></a></span>

                        	<div class="clear"></div>

                     	</li>

                        <?php	

						}

						

						if($job->getUrl()){

							echo "<li><span>" . __('Email') .": </span><span class=\"button\"><a style=\"margin-bottom: 5px;\" class=\"blueSmall\" href=\"" . $job->getUrl() . "\"><span>" . __('Apply job') . "</span></a></span></li><div class=\"clear\"></div>";

						}

					?>

				</ul>   

                <div class="buttons ">

                    <?php if ($product->getBuyOnline() == 1): ?>

                        <span class="button"><a href="/shopping/addProductToBasket?product_id=<?php echo $product->getId() ?>" class="yellow" title="<?php echo __('Buy') ?>" id="addToBasket"><span><?php echo __('Buy') ?> &raquo;</span></a></span>

              <?php endif; ?>

              		<?php if($job->getCName1()): ?>

                      	<?php if($job->getCEmail1()): ?>

                      	<span class="button ask_button">

                            <a class="graySmall" href="javascript:;"  onclick="AskQuestion(<?php echo $product->getId() ?>)"><span><?php echo __('Ask a question') ?></span></a>

                        </span>

                      	<?php endif; ?>

                   <?php endif; ?>

              		<?php if($job->getCName2()): ?>

                      	<?php if($job->getCEmail2()): ?>

                      	<span class="button ask_button">

                            <a class="graySmall" href="javascript:;"  onclick="AskQuestion(<?php echo $product->getId() ?>)"><span><?php echo __('Ask a question') ?></span></a>

                        </span>

                      	<?php endif; ?>

                   <?php endif; ?>

                        

                        <div class="clear"></div>

                        <ul class="share">

                            <li><a href="#" onClick="window.print()" class="print" title="<?php echo __('Print') ?>"><span><?php echo __('Print') ?></span></a></li>

                            <li><a href="#" onclick="MailTo(<?php echo $product->getId() ?>)" class="email" title="<?php echo __('Send friends') ?>"><span><?php echo __('Send friends') ?></span></a></li>

                            <li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode('http://yozoa/album/' . $product->getId()) ?>" class="facebook" title="share Facebook friends"><span>Facebook</span></a></li>

                            <li><a href="http://twitter.com/home/?status=<?php echo urlencode($product->getName()) ?>:%20<?php echo urlencode('http://yozoa/album/' . $product->getId()) ?>" class="twitter"  title="share twitter"><span>Twitter</span></a></li>

                        </ul>

                </div>

                <div class="clear"></div>

        </div>  

        </div>      

            </div>

		</ul>

                    

	                

                  </div><!--product-details-->

                  <div class="clear"></div>

