<?php use_helper('Text');?>
<tr class="<?php echo ($i % 2==0)? "even":"odd" ?>">
  <td align="center" width="10%" style="padding-left:10px;">
   <?php 
	   if($product->getCategoryType() == 'jobs') {
	     $job = $product->getJob();
	     if ($job->getLogo()) { ?>
			<?php if(file_exists(sfConfig::get('sf_upload_dir').'/product-image-1/t_'.$job->getLogo()))
					{	echo link_to(image_tag('/uploads/product-image-1/t_'.$job->getLogo()), 'product_show', $product); } 
					
				 else if (file_exists(sfConfig::get('sf_upload_dir').'/product-image-2/t_'.$job->getLogo()))
					{	echo link_to(image_tag('/uploads/product-image-2/t_'.$job->getLogo()), 'product_show', $product); }
					
				 else 
					{	echo link_to(image_tag('/images/t_default.jpg'), 'product_show', $product); }
         } else {
		 		echo link_to(image_tag('/images/t_default.jpg'), 'product_show', $product);
		 } 
	} else { ?>
   	<?php echo link_to(image_tag($product->getImagePath("t_")), 'product_show', $product);
	}?>
  </td>
  <td>
	<?php if ($status == 1):?>
    <a href="<?php echo url_for('product_show', $product) ?>"><?php echo truncate_text(getProductName($product, $sf_user->getCulture()),'90','..'); ?></a>
	<?php else:?>
		<?php echo truncate_text(getProductName($product, $sf_user->getCulture()),'90','..'); ?>
	<?php endif;?>
  </td>
  <td>
    <?php $ps = Doctrine::getTable('ProductStat')->readCount($product->getId()); echo $ps?$ps->getReadCount():0;?>
  </td>
  
  <?php if ($status == 1):?>
  	<td class="date" align="center"><?php echo date("Y-m-d", strtotime($product->getConfirmedAt()))?></td>
  <?php else:?>
  	<td class="date" align="center"><?php echo date("Y-m-d", strtotime($product->getCreatedAt()))?></td>
  <?php endif;?>
  
  <?php if ($status == 1):?>
  <td class="date" align="center"><?php echo date("Y-m-d", strtotime($product->getExpireDate()))?></td>
  <?php endif?>
  <td nowrap>
    <?php echo link_to(__('Edit'), 'manageProduct/edit?id='.$product->getId())?>
    <br/>    
    <?php echo link_to(__('Delete'), 'manageProduct/delete?id='.$product->getId(), 'confirm="'. __('Are you sure ?') .'"')?>
    <br/>    
    <?php //if ($product->getStatus() == 1) echo link_to("Advertise", 'manageProduct/addDoping?id='.$product->getId()) ?>
    <br/>    
    <?php if ($product->getStatus() >= 1 ):?>
    <a href="#" onclick="showExtendDialog('<?php echo $product->getId()?>'); return false;"><?php echo __('Extend') ?></a>
    <?php endif?>
  </td>
</tr>