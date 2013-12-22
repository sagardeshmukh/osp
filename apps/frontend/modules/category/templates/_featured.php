<div class="box clear" style="width:722px;">
    <div class="boxHeader"><div><h3><?php echo __('Recommended for you') ?>.</h3></div></div>
     <div class="boxContent">
         <div class="five-col-one last">
		<?php foreach($categories as $i => $category):?>
	      	<?php $product = Doctrine::getTable('Product')->getItemWithPhoto($category->getId())?>
	      	<?php if($product instanceOf Product):?>
             <div class="item  last-item">
                 <div style=" color:#FF6803; font-weight:bold;"><?php echo $category->getDescription()?> </div>
				
				<div class="image"><?php echo link_to(image_tag($product->getImagePath("s_"), array("size" => '117x88')), url_for('@product_browse?categoryId='.$category->getId().'&xType=cars'))?></div>
				<div class="content">
				 <a  class="smaller" href="<?php echo url_for('@product_browse?categoryId=' . $category->getId().'&xType=cars' ); ?>"><?php echo $category->getName()?></a>
				</div>
			</div>
                 <?php endif?>
             <?php endforeach?>
	      <div class="clear"></div>
	    </div><!--similar-products-->
    </div><div class="boxFooter"><div></div></div>
</div>