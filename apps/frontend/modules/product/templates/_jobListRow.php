<?php $job = Doctrine::getTable('Job')->getProductJob($product->getId()) ?>

    <tr class="<?php if ($product->hasDoping(myConstants::$DIFFERENT)) echo "featured"?>">

  <td width="80" style="padding-left:10px;">

  <?php //LNA - 14.06.2011 ?>
		
    <?php  if($job->getLogo()) {
	
	 			if(file_exists(sfConfig::get('sf_web_dir') . '/uploads/product-image-1/t_'.$job->getLogo())) {
					 
					 echo link_to(image_tag('/uploads/product-image-1/t_'.$job->getLogo()), 'product_show', $product);
					 
				} else if(file_exists(sfConfig::get('sf_web_dir') . '/uploads/product-image-2/t_'.$job->getLogo())) {
				 	 
					 echo link_to(image_tag('/uploads/product-image-2/t_'.$job->getLogo()), 'product_show', $product);
					 
				} else {
					 echo link_to(image_tag('/images/t_default.jpg'), 'product_show', $product);
				}
		   } else {
		   		echo link_to(image_tag('/images/t_default.jpg'), 'product_show', $product);
		   } ?>
  </td>

  <td style="padding-left: 15px; width: 350px; text-align: left;">

    <a href="<?php echo url_for('product_show', $product)?>"><?php echo getProductName($product, $sf_user->getCulture())?></a>

    <br/>

    <div style="text-align: left;">

        <?php echo substr($job->getDescription(), 0, 100) ?>

    </div>

  </td>

  <td style="text-align: center;">

      <a href="<?php echo url_for('product_show', $product)?>"><?php echo $job->getCompanyName() ?></a>

  </td>

  <td style="text-align: center;" class="date" align="center"><?php echo $product->getXArea()->getName().'<br />'.date('Y-m-d', strtotime($job->getDeadline())) ?></td>

</tr>