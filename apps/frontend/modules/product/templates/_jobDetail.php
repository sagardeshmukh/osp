<?php
    $job = $product->getJob();
?>
<div class="boxContent" >
    <div class="boxWrap">
        <div class="right"><?php echo __('Yozoa code') ?>: <?php echo $product->getId() ?></div>
        <h1><?php echo $product->getName(); ?></h1>
		<div style="float: left; width: 22%;">
            <div class="large-pic">
                <?php if ($job->getLogo()): ?>
                    <?php if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/product-image-1/s_'.$job->getLogo())) echo image_tag('/uploads/product-image-1/s_'.$job->getLogo()); ?>
                    <?php if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/product-image-2/s_'.$job->getLogo())) echo image_tag('/uploads/product-image-2/s_'.$job->getLogo()) ?>
                <?php endif; ?>
            </div>
        </div>
		<div class="clear">&nbsp;</div>

      <div style="float: left; width: 100%; margin-bottom: 20px; text-align: justify;">
          <div class="heading-brief-title"><?php echo __('Company Information') ?></div>
          <?php echo $job->getDescription() ?>
                    <div class="clear"></div>
      </div>
<div class="clear"></div>

      <div style="float: left; width: 100%;">
          <div class="heading-brief-title"><?php echo __('Description') ?></div>
          <?php echo $product->getDescription() ?>
      </div>
      
      <?php /*?><div style="float: right; width: 300px; background: none repeat scroll 0 0 #EBF4F9;
    border: 1px solid #DDDDDD;
    padding: 0 8px 8px;" class="product-details">
    <h4 class="job-brief-heading"><?php echo __('Brief Post') ?></h4>
    <ul style="margin: 8px 0;" class="details">
         <li><span><?php echo __('Deadline') ?></span><?php echo $job->getDeadline() ?></li>
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
          <ul style="margin: 8px 0;" class="details">
              <?php if($job->getCName1()): ?>
              <li><span><?php echo __('Contact') ?>:</span><?php echo $job->getCName1() ?></li>
              <?php if($job->getCTitle1()): ?>
              <li><span><?php echo __('Title') ?>:</span><?php echo $job->getCTitle1() ?></li>
              <?php endif; ?>
              <?php if($job->getCPhone1() && $job->getIsPhone() == false): ?>
              <li><span><?php echo __('Phone') ?>:</span><?php echo $job->getCPhone1() ?></li>
              <?php endif; ?>
              <?php if($job->getCEmail1()): ?>
              <li><span><?php echo __('Email') ?>:</span><a href="<?php echo url_for('sendFriend/contact?p_id='.$product->getId()) ?>"><?php echo __('Send e-post') ?></a></li>
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
              <?php if($job->getCEmail2()): ?>
              <li><span><?php echo __('Email') ?>:</span><a href="<?php echo url_for('sendFriend/contact?p_id='.$product->getId()) ?>"><?php echo __('Send e-post') ?></a></li>
              <?php endif; ?>
              <?php endif; ?>
          </ul>
          <?php endif; ?>
    
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
                    <div class="clear"></div>

                  </div><?php */?><!--product-details-->
                  
                  <div class="clear"></div>
                </div>
              </div>

          <div class="boxFooter"><div></div></div>
          <div class="clear">&nbsp;</div>
          
