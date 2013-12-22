<div class="leftSidebar">

  <span class="button"><a title="<?php echo __('+ Add product') ?>" class="yellow" href="<?php echo url_for('manageProduct/step1')?>"><span style="color: #333"><?php echo __('+ Add '.ucfirst(substr($xType, 0, -1))) ?><font style="color: #666"> (Free)</font></span></a></span>

  <br clear="all"/>

  <br clear="all"/>



  <div class="box boxSidebarBlue">

    <div class="boxHeader"><div><h3><?php echo __('Categories') ?></h3></div></div>

    <div class="boxContent">

      <?php include_component('category', 'leftMenu')?>

    </div>

    <div class="boxFooter"><div></div></div>

  </div><!--box-->

  

  <?php include_component('help','rightMenu')?>

  

</div><!--sidebar-->

<?php if($xType == 'realestates'): ?>

    <ul class="SearchView">

                <li class="map">

                    <a href="<?php echo url_for('product/realestateMapAdvancedSearch') ?>"><span class="search_icon map"></span>Map view</a>                </li>



                <li class="list selected">

                    <span class="search_icon list"></span>

                    List view                    <i class="view_corner tl"></i>

                    <i class="view_corner tr"></i>

                    <i class="view_corner bl"></i>

                    <i class="view_corner br"></i>

                </li>

            </ul>

 <?php endif; ?>

<div class="contentColumn">



  <?php include_partial('banner/show', array("categoryId"=>$sf_params->get("categoryId")))?>

  

  <div class="box boxYellow">

    <div class="boxHeader"> 

    	<div>

    		<h3 style="width: 700px"><?php echo $category->getName()?> - Subpage products<a href="/help/24#category_doping" class="vtip" style="float: right;  font-weight: 100; color: gray" title="When you insert your product, you should choose <b>Put subpage</b>, after that your product will put in here.">Would you put your product in here?</a></h3>

    	</div>

    </div>

    <div class="boxContent">

      <?php $i = 0; ?>

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

    

  <?php include_component('product', 'featured')?>

</div>



<div class="clear"></div>