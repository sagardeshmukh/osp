
<div class="box boxSidebar user-information-new">
    <div class="boxHeader"><div><h3><?php echo __('Main information') ?></h3></div></div>
      <div class="boxContent">
        <div class="boxWrap">
          <div class="user-profile">
            <?php /*?><div class="image">
              <div class="profile-image">
                <div class="img-holder medium">
                  <?php $ispaid = 0; ?>
                  <span class="<?php if($ispaid==1){echo "business";}else{if($ispaid==2){echo "support";}else{echo "free";}}?>-member"></span>
                      <img border="0" width="60" height="60" title="<?php echo $user->getFirstname()?>" src="/uploads/profile/<?php echo ceil($user->getId()/300)?>/s_<?php echo $user->getImage()?>"/>
                </div>
              </div>
            </div><?php */?>
            <div class="info">
              <span><b><?php echo __('First Name'); ?>: </b><?php echo $user->getName()?></span>
              <span><b><?php echo __('Last Name'); ?>: </b><?php echo $user->getLastname() ?></span>
            </div>
          </div><!--user-profile-->
          <ul class="contact-tools">
           <?php if($user->getEmail()){?><li><span class="name"><?php echo __('Email') ?>: <?php echo $user->getEmail()?></span></li><?php }?>
            <!--li><span class="name">Fax:  <?php// echo $salesMan->getFax()?></span></li-->
          </ul>
        </div>
      </div>
    <div class="boxFooter"><div></div></div>
  <br clear="all"/>
  </div><!--box-->

  <div class="box boxSidebar user-information-last">
    <div class="boxHeader"><div><h3><?php echo __('Products') ?></h3></div></div>
      <div class="boxContent">
        <div class="boxWrap">
          <div style="padding: 5px;">
          	<div class="div-gallery-view">
          	<?php 
				$product = Doctrine::getTable('Product')->browseQuery(array('userId'=>$user->getId()));
				
				$query = Doctrine::getTable('Product')->browseQuery(array('userId'=>$user->getId()));
	
				//pager
				$this->pager = new sfDoctrinePager('Product', 16);
				$this->pager->setQuery($query);
				$this->pager->setPage(1);
				$this->pager->init();
			
				$nbResult = $this->pager->getNbResults(); //nb of product
				$products = $this->pager->getResults();
				$i = 0;
				foreach ($products as $product)
				{
					if($i%2 == 0) echo "<div class=\"row\">";
					$i++;
					?>
				 	<div class="item<?php if ($product->hasDoping(myConstants::$DIFFERENT))
					  echo " featured" ?>">
					  <div class="wrap">
						<div class="image">
							<a href="<?php echo url_for("@album?product_id=".$product->getId()) ?>" ><?php echo image_tag($product->getImagePath("s_"), array("width" => 150)); ?></a>
						</div>
						<div class="info">
						  <h3>
							<a href="<?php echo url_for("@album?product_id=".$product->getId()) ?>"><?php echo getProductName($product, $sf_user->getCulture()) ?></a>
						  </h3>
						  <p class="price"><?php echo $product->getPrice($sf_user->getPreffCurrency()) ?></p>
						  <p class="compare-hide" style="display: none;">
							<input id="compare_id_<?php echo $product->getId() ?>" class="compare-select" type="checkbox" name="compareId[]" value="<?php echo $product->getId() ?>" />
							<label for="compare_id_<?php echo $product->getId() ?>"><?php echo __('Compare') ?></label>
					<?php echo image_tag($product->getImagePath("t_"), 'style=display:none;'); ?>
						  </p>
						  <ul>
							<li><?php echo __('Time left') ?>: <?php echo date('Y-m-d', strtotime($product->getConfirmedAt())) ?></li>
							<li>
							  <?php
							  $salesMan = $product->getUser();
							  echo link_to($salesMan->getInitial() . "." . $salesMan->getFirstname(), '@product_browse?userId=' . $product->getUserId().'&xType='.$product->getCategoryType());
							  ?>
							</li>
						  </ul>
						</div>
						<div class="clear"></div>
					  </div>
					</div>
                    
				<?php 
					if($i%2 == 0) echo "</div>";
				}	?>
            <div class="clear"></div>
            </div>
               <div class="clear"></div>
          </div>
         </div>
      </div>
    <div class="boxFooter"><div></div></div>
  <br clear="all"/>
  </div><!--box-->
  <br clear="all"/>