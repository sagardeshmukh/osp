  <!-- big store start-->
    <div class="box boxYellow">
      <div class="boxHeader">
          <div>
              <a href="<?php echo url_for('@category_home?xType=realestates')?>"><h3 style="width: 700px"><?php echo __('New construction projects') ?></h3></a>
          </div>
      </div>
      <div class="boxContent">
	      <?php foreach($products as $i => $product):?>
	        <?php if ($i % 5 == 0):?>
		        <div class="five-col-one">
		      <?php endif?>
		    
		      <?php include_partial('homeItem', array('product' => $product, 'sf_cache_key'=> $product->getCacheKey()))?>
		    
			    <?php if ($i % 5 == 4):?>
  		        <div class="clear"></div>
  		      </div>
	        <?php endif;?>
	        
	      <?php endforeach?>
	      
	      <?php if (count($products) && $i % 5 != 4):?>
  	        <div class="clear"></div>
  	      </div>
	      <?php endif?>
      </div>
      <div class="boxFooter"><div></div></div>
    </div><!--boxYellow-->
  <!-- big store end-->

