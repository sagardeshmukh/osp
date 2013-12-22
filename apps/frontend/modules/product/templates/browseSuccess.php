<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<?php use_helper('JavascriptBase') ;
//use_helper('jQuery'); ?>

<style type="text/css">
	.focuseffect{background-color:#EDEDDE;  }
	.hidebox:hover{text-decoration:underline; cursor:pointer;}
	.ulpading{ padding-left:20px;}
	.leftSidebar { background-color: #F1F1F1; }
</style>

<?php 
	// LNA
	$initial_av = implode("|",$attribute_value_ids);

	$queryString = '?xType='.$xType.generateSearchParameterString($browseParams); 
?>
<?php $av_table = Doctrine::getTable('AttributeValues');?>
<?php $currSymbol = $sf_user->getCurrSymbol() ?>
<!-- Breadcrumbs -->
<?php if($contentView == 'listview'){ ?>
<div class="bread-crumb"> <a href="<?php echo url_for('@homepage')?>" class="home" style="z-index:100;"></a>
  <?php $z_index = 100;?>
  <?php foreach($parent_categories as $parent_category):?>
  <?php if ($parent_category->getIsVisible() == 0) continue;?>
  <?php
    $z_index--;
    if ($parent_category->getParentId() == 0) {
      echo link_to($parent_category->getName(), url_for('@product_browse?xType='.$xType), array("style" => "z-index:{$z_index}"));
	   //LNA ?categoryId='.$parent_category->getId().'
    } else {
      	echo link_to($parent_category->getName(), '@product_browse?categoryId='.$parent_category->getId().'&xType='.$xType, array("style" => "z-index:{$z_index}"));
    } 
	endforeach;
    // show the category names on Breadcrumbs when select multiple categories.
	if($is_array_category){
		$i = 0;
		foreach($customSelectedCategories as $selected_cat){
			if($i == 0){
				$cat_name = $selected_cat->getName();
				$cat_id = $selected_cat->getId();
			}
			if($i == 1 && (count($customSelectedCategories) > 1)){
				$cat_name_sufix =substr($selected_cat->getName(), 0, 5)."...";
				$sufix_cat_id = $selected_cat->getId();
				break;
			}
			
			$i++;
		}
		if(count($customSelectedCategories) > 1)
			echo link_to($cat_name.",", '@product_browse?categoryId='.$cat_id.'&xType='.$xType).link_to($cat_name_sufix, '@product_browse?categoryId='.$sufix_cat_id.'&xType='.$xType, array('style'=>'padding: 0 15px 0 0'));
		else
			echo link_to($cat_name, '@product_browse?categoryId='.$cat_id.'&xType='.$xType);
	} 
  ?>
  <a href="<?php echo url_for('@rss?categoryId='.$parent_category->getId())?>" style="float: right; background: none; padding: 7px;z-index:100;"><img src="/images/rss.gif" alt="<?php echo $parent_category->getName()?>" title="<?php echo $parent_category->getName()?>"/></a> </div>
<?php } ?>
<!-- Breadcrumbs -->
<?php if($xType == 'realestates'){?> 
<form id="" name="frm2" action="" >
<input id="lastPostingId4" type="hidden" name = "lastPosting" value="<?php echo isset($lastPosting) ? $lastPosting : ''; ?>" />
<input id="priceRangeId4" type="hidden" name = "priceRange" value="<?php echo isset($priceRange)? $priceRange : ''; ?>" />
<?php	if($contentView == 'listview'){?>
<ul class="SearchView ulpading">
  <li class="map"> <a href="<?php echo url_for('@product_browse'.$queryString.'&contentView=mapview') ?>" onClick="this.href = this +'&lastPosting='+document.frm2.lastPosting.value;+'&priceRange='+this+document.frm2.priceRange.value;"><span class="search_icon map"></span>Map view</a></li>
  <li class="list selected"> <span class="search_icon list"></span> <?php echo __('List view');?> <i class="view_corner tl"></i> <i class="view_corner tr"></i> <i class="view_corner bl"></i> <i class="view_corner br"></i> </li>
</ul>

<?php }else if($contentView == 'mapview'){ ?>
<div id="header" style="height:35px;">			
<!--	<div id="logo"><a href="<?php echo url_for("@homepage") ?>" style="height:55px;"></a>
	<div style="padding-top: 45px; padding-left: 0px; color: #ccc">
		Beta version...
	</div>
	</div>-->
	<ul class="SearchView ulpading">
	  <li class="list selected">Map view<i class="view_corner tl"></i><i class="view_corner tr"></i><i class="view_corner bl"></i><i class="view_corner br"></i></li>
	  <li class="list"><span class="search_icon list"></span>
		<a href="<?php echo url_for('@product_browse'.$queryString.'&contentView=listview') ?>" onClick="this.href = this +'&lastPosting='+document.frm2.lastPosting.value;"><span class="search_icon list"></span> List view </a>
	  </li>
	</ul>
</div><!--header-->
<?php }
echo "</form>";
 } ?>
<?php if($contentView == 'listview'){?>
<div class="leftSidebar" />
<!-- Filterd attribute array -->
<?php $filterAttributeName = array();
 	  if($filtered_values){

    	$attributes_for_filtered_values = array();

    	foreach($filtered_values as $fvalue){
     		$attributes_for_filtered_values[$fvalue->getAttributeId()][$fvalue->getId()] = $fvalue;
    	}
 	 }
?>
<!-- End of Filterd attribute array -->

<!-- You have search -->
  <?php if($is_array_category == true || count($parent_categories) > 2 || $lastPosting || $priceRange || is_array($xAreaId) || isset($attributes_for_filtered_values)){ ?>
  <div class="box boxSidebarYellow">

    <div class="boxHeader"><div><h3><?php echo __('You have searched') ?></h3></div></div>

    <div class="boxContent">

      <ul class="cats">

          <?php foreach($customSelectedCategories as $selected_category){?>  <!-- for Categories --> 
        		<li>
          			<?php 
					 $queryStringForCategory = explode("&",$queryString);
					 unset($queryStringForCategory[0]);
					 if($is_array_category) {
						 $query_string_array_for_selected = join("&", array_diff_key($query_string_array, array($selected_category->getId() => true)));
						 unset($queryStringForCategory[1]);
						 $queryStringForCategory = $query_string_array_for_selected."&".implode("&",$queryStringForCategory);
					 } else{
					 	$queryStringForCategory = str_replace("categoryId=".$selected_category->getId(),"",implode("&",$queryStringForCategory));
					 }
	  				 echo link_to(" x ", "@product_browse?xType=".$xType, array("query_string" => $queryStringForCategory ));
          			 echo $selected_category->getName() ?>
        		</li>
         <?php } ?>
		
		<?php if($lastPosting){ ?>								<!-- for Last Posting --> 
				<li> <a href="<?php echo url_for('@product_browse'.str_replace('&lastPosting='.$lastPosting,"&lastPosting=",$queryString));?>">x</a> <?php echo "Last ".$lastPosting." days posting." ?> </li>
		<?php } ?>
		
		<?php if($priceRange && strpos($priceRange, '-') !== false){ 
				list($min_price, $max_price) = explode('-', $priceRange); ?>								<!-- for Price option --> 
			<li> <a href="<?php echo url_for('@product_browse'.str_replace($priceRange,"",$queryString));?>">x</a> <?php echo "Price Range ".formatPrice($min_price, $currSymbol)?> - <?php echo is_numeric($max_price) ? formatPrice($max_price, $currSymbol):__('More') ?> </li>
		<?php } ?>
		
		<?php foreach($customSelectedLocations as $selected_location){       /* for Locations */
				if($selected_location->getId() > 0){ ?>
					<li>
						<?php
						 $queryStringForLocation = explode("&",$queryString);
						 unset($queryStringForLocation[0]);
						 if($is_array_location) {
						 	 if(count($xAreaId) > 1){
								 $query_string_array_for_selected = join("&", array_diff_key($query_string_array, array($selected_location->getId() => true)));
								 unset($queryStringForLocation[2]);
								 $queryStringForLocation = $query_string_array_for_selected."&".implode("&",$queryStringForLocation);
							} else {
								unset($queryStringForLocation[2]);
								$queryStringForLocation = "xAreaId=0&".implode("&",$queryStringForLocation);
							}
						 } else{
							$queryStringForLocation = str_replace("&xAreaId=".$selected_category->getId(),"&xAreaId=0",implode("&",$queryStringForLocation));
						 }
						 echo link_to(" x ", "@product_browse?xType=".$xType, array("query_string" => $queryStringForLocation));
						 echo $selected_location->getName() ?>
					</li>
          <?php }
		  } ?>
		
	    <?php if(isset($attributes_for_filtered_values)){					/* for Attributes */
				foreach($attributes_for_filtered_values as $fid => $fattr){
		 		 $sattr = Doctrine::getTable('Attribute')->find($fid); ?>
				 
			     <?php foreach($fattr as $filtered_value){ ?>
							<li> <a href="<?php echo url_for('@product_browse'.str_replace($filtered_value->getId(),"",$queryString));?>">x</a> <?php echo $filtered_value->getValue()?> </li>
					<?php }?>
				
		 <?php }
 			} ?>
	  </ul>
        <?php $make_clear_query['categoryId'] = "categoryId=" . $sf_user->getAttribute('clear_parent_category');?>

        <?php $make_clear_query_array_for_selected = join("&", $make_clear_query);?>

		<input type="button" value="Save search" onclick="saveSearch()"/>
    </div>
	<div id="saveSearch" style="margin-left:10px; margin-right:10px; display: none;">
		<ul class="cats">
			<li>
				Name this search : <input id="saveSearchName" type="text" name="saveSearchName" size="15"/>
			</li>
			<li>
				<input type="checkbox" id="emailDaily"/> Email me daily when new items match my search.
			</li>
				 <input type="hidden" value="" size="15"/>
				 <?php if(!$sf_user->isAuthenticated())  // set session variable.
				 		$sf_user->setAttribute('saveSearchPageUrl', $queryString); ?>
				<input id="<?php echo $sf_user->isAuthenticated()? 'saveSearchId' : 'login'; ?>" type="button" value="Save" /> <div class="loading"></div>
			
		</ul>
	</div>
	<div class="showLink">
	</div>
    <div class="boxFooter"><div></div></div>

  </div><!--box-->
  <?php } ?>
  <!-- You have search end -->
  <?php if(count($child_categories)):?>
  <div class="box boxSidebarBlue ">
    <div class=" boxHeader catfrmt hidebox boxeseffect">
	
      <h3><?php echo __('Categories') ?></h3>
    </div>
    <div class="hidecategory ">
      <form id="browseCategories" name="frm" action="<?php echo $is_array_category == false ? url_for('@product_browse'.$queryString): '' ?>" >
        <?php if(isset($initial_av) && $initial_av) { ?>
        			<input type="hidden" name = "av" id="av" value="<?php echo $initial_av; ?>" />
        <?php  } 
			  if($is_array_location) { 
				foreach ($xAreaId as $a_id => $a_value_id) {?>
        			<input type="hidden" name = "xAreaId[]" value="<?php echo $a_value_id; ?>" />
        <?php  }  
			  } else { ?>
        			<input type="hidden" name = "xAreaId" value="<?php echo $xAreaId; ?>" />
        <?php } ?>
					<input id="lastPostingId1" type="hidden" name = "lastPosting" value="<?php echo isset($lastPosting) ? $lastPosting : ''; ?>" />
					<input type="hidden" id="priceRangeId1" name = "priceRange" value="<?php echo isset($priceRange)? $priceRange :''; ?>" />
					<input type="hidden" name = "contentView" value="<?php echo $contentView; ?>" />
        <ul class="cats ulpading">
          <?php foreach($child_categories as $child_category):?>
          <?php if ($child_category->getIsVisible() == 0) continue;?>
          <li>
            <input type="checkbox" value="<?php echo $child_category->getId() ?>" name="categoryId[]">
            <a href="<?php echo url_for('@product_browse'.$queryString.'&categoryId='.$child_category->getId() )?>" onClick="this.href = this +'&lastPosting='+document.frm.lastPosting.value;"><?php echo $child_category->getName()?></a> <em>(<?php echo $child_category->getNbProduct()?>)</em> </li>
          <?php endforeach?>
        </ul>
		<?php //if($is_array_category == false): ?>
          <input type="submit" name="category" value="Search" class="button" style="margin:5px 0px 10px 15px; " />
        <?php //endif; ?>
		<?php if($is_array_category == true || count($parent_categories) > 2){?>
				  <a href="<?php echo url_for('@product_browse'.$queryString.'&rootCategory=1');?>" style="padding-left: 10px; text-decoration:none"><input type="button" value="Back"/></a>
		<?php } ?>
      </form>
    </div>
  </div>
  <!--box-->
  <?php endif?>
  <!--posting box-->
  <div class="box boxGray">
    <input type="hidden" id="days"/>
    <div class="">
      <div class="filter-cats  ">
        <h4 class="boxeseffect  hidebox"  ><img src="/images/show.jpg" alt=""/> <?php echo __('Last Posting') ?><span id="loading_img1"></span></h4>
        <ul class="cats ">
          <div class="demo" style="width: 85%; padding-left:18px;"> Last
            <input type="text" id="lastPostingDays" value="<?php echo isset($lastPosting)? $lastPosting : ''; ?>" size="3">
            Days posting. </div>
          <!-- End demo -->
        </ul>
      </div>
      <!--fiter-cats-->
    </div>
    <div class=""></div>
  </div>
  <!--posting box end-->
  
    <!--<div class="box boxGray">
    <div class=" boxNoTitle">
     
    </div>
    <div class="">
      <div class="filter-cats">
        <h4 class="boxeseffect hidebox"><img  src="/images/show.jpg" alt=""/> <?php echo __('Price Range') ?><span id="loading_img2"></span></h4>
		<ul class="cats ">
		<div align="center" style="padding-left:40px;"><input name="priceRange" type="text" id="amount" style="border:0; color:#FF6803; background:#F1F1F1; font-weight:bold; " /></div>
		<div style="padding-left:15px;"><div class="slid"  style="width:205px;"  id="slider-range"></div></div>
        <?php  
				// Preper a query string for price.
			/*	$queryStrForPrice = explode('&',$queryString); 
				unset($queryStrForPrice[0]); 
				$queryStringForPrice = implode('&',$queryStrForPrice); */
		?>
		</ul>    
     </div>
    </div>
    <div class="">
     
    </div>
  </div>
-->
  
  <!-- Price Range -->
  <?php if ($priceRange && strpos($priceRange, '-') !== false):?>
  <?php list($min_price, $max_price) = explode('-', $priceRange); ?>
  <?php $query_string = join("&", array_diff_key($query_string_array, array('priceRange' => true)));?>
  <?php endif?>
  <?php if (isset($price_values) && count($price_values) > 1) { ?>
  <div class="box boxGray">
    <div class=" boxNoTitle">
     
    </div>
    <div class="">
      <div class="filter-cats ">
        <h4 class="boxeseffect hidebox"><img  src="/images/show.jpg" alt=""/> <?php echo __('Price') ?></h4>
        <?php  
				// Preper a query string for price.
				$queryStrForPrice = explode('&',$queryString); 
				unset($queryStrForPrice[0]); 
				$queryStringForPrice = implode('&',$queryStrForPrice); 
		?>
        <ul class="cats ulpading">
          <li class="f"> Min :
            <input type="text" id="bpricemin" size="6" />
            Max :
            <input type="text" id="bpricemax" size="6" />
            <input type="submit" value="Search" id="bpricesearch" />
          </li>
        </ul>
      </div>
    </div>
    <div class="">
     
    </div>
  </div>
  <?php } else if($priceRange && strpos($priceRange, '-') !== false){ ?>
  <div class="box boxGray">
    <div class=" boxNoTitle">
      
    </div>
    <div class="">
      <div class="filter-cats ">
        <h4 class="boxeseffect hidebox"><img src="/images/show.jpg" alt=""/> <?php echo __('Price') ?></h4>
        <ul class="cats ulpading">
          <li class="f"> <a href="<?php echo url_for('@product_browse'.str_replace($priceRange,"",$queryString));?>">x</a> <?php echo formatPrice($min_price, $currSymbol)?> - <?php echo is_numeric($max_price) ? formatPrice($max_price, $currSymbol):__('More') ?> </li>
        </ul>
      </div>
    </div>
    <div class="">
   
    </div>
  </div>
  <?php } ?>
  <!-- Price Range -->

<?php
   $queryStrForChooseMore = explode('&',$queryString); 
   unset($queryStrForChooseMore[0]); 
   $query_string_array_for_script = implode('&',$queryStrForChooseMore);
 ?>
  <?php if(isset($attributes_for_filtered_values)): ?>
  <?php foreach($attributes_for_filtered_values as $fid => $fattr): ?>
  <?php $sattr = Doctrine::getTable('Attribute')->find($fid); ?>
  <div class="box boxGray">
    <div class=" boxNoTitle">
      
    </div>
    <div class="">
      <div class="filter-cats ">
        <h4 class="boxeseffect hidebox"> <img src="/images/show.jpg" alt=""/> <?php echo $sattr->getName() ;
				$filterAttributeName[$fid] = $sattr->getName();
			
		 ?></h4>
        <ul class="cats ulpading">
          <?php foreach($fattr as $filtered_value): ?>
          <li class="f"> <a href="<?php echo url_for('@product_browse'.str_replace($filtered_value->getId(),"",$queryString));?>">x</a> <?php echo $filtered_value->getValue()?> </li>
          <?php endforeach;?>
          <li class="asr-v asr-md"><a href="javascript:;" id="<?php echo $filtered_value->getAttributeId() ?>">Choose more<span> <?php echo $filtered_value->getAttributeName() ?></span>...</a></li>
        </ul>
      </div>
      <!--fiter-cats-->
    </div>
    <div class="">
    
    </div>
  </div>
  <?php endforeach;?>
  <?php endif; ?>
  <!-- xareas -->
  <?php if(count($xAreas)):?>
  <div class="box boxGray">
    <div class=" boxNoTitle">
      
    </div>
    <div class="">
      <div class="filter-cats locationboxeffect ">
       <h4 class="hidebox hidecatbox" ><img src="/images/show.jpg" alt=""/> <?php echo __('Locations') ?></h4>
		<div>
        <?php //LNA 14.06.2011 ?>
        <?php 
		if ($xAreaId != 0){ ?>
        <form id="browseLocations" name="frm1" action="<?php echo $is_array_location == false ? url_for('@product_browse'): '' ?>" >
          <?php if($is_array_category) { 
				 foreach ($category_id as $c_id => $c_value_id) {?>
          			<input type="hidden" name = "categoryId[]" value="<?php echo $c_value_id; ?>" />
          <?php  }  
				} else { ?>
          			<input type="hidden" name = "categoryId" value="<?php echo $category_id; ?>" />
          <?php } 
		 		if(isset($initial_av) && $initial_av) { ?>
          			<input type="hidden" name = "av" id="av" value="<?php echo $initial_av; ?>" />
          <?php } ?>
          			<input type="hidden" id="priceRangeId2" name = "priceRange" value="<?php echo isset($priceRange)? $priceRange:''; ?>" />
		  			<input id="lastPostingId2" type="hidden" name = "lastPosting" value="<?php echo isset($lastPosting) ? $lastPosting : ''; ?>" />
					<input type="hidden" name = "contentView" value="<?php echo $contentView; ?>" />
          <ul class="cats ulpading">
            <?php foreach($xAreas as $i => $xArea):?>
            <li class="f<?php if ($i > 4) echo " hide";?>">
              <label class="hand">
              <input type="checkbox" name="xAreaId[]" value="<?php echo $xArea->getId(); ?>" />
              <?php echo $xArea->getName()?></label>
              <em>(<?php echo $xArea->getNbProduct()?>)</em> </li>
            <?php endforeach?>
            <?php if ($i > 4):?>
            <li class="hideShowCat"><a title="Other" class="open" href="#"><?php echo __('Other') ?></a></li>
            <?php endif?>
          </ul>
		  <input type="submit" name="location" value="Search" class="button" style="margin:5px 0px 10px 15px; ">
          <a href="<?php echo url_for('@product_browse'.$queryString.'&rootLocation=1');?>" style="padding-left: 10px; text-decoration:none"><input type="button" value="Back"/><?php //echo __('clear'); ?></a>
        </form>
        <?php

        }else{

		?>
        <ul class="cats ulpading">
		  <form id="browseLocations" name="frm1" action="<?php echo $is_array_location == false ? url_for('@product_browse?xType='.$xType): '' ?>" >
		  <input id="lastPostingId3" type="hidden" name = "lastPosting" value="<?php echo isset($lastPosting) ? $lastPosting : ''; ?>" />
		  <input id="priceRangeId3" type="hidden" name = "priceRange" value="<?php echo isset($priceRange)? $priceRange : ''; ?>" />
          <?php foreach($xAreas as $i => $xArea): ?>
          <li class="f<?php if ($i > 4) echo " hide";?>"> <a href="<?php echo url_for('@product_browse'.str_replace('&xAreaId=0',"&xAreaId[]=".$xArea->getId(),$queryString) );?>" onClick="this.href = this +'&lastPosting='+document.frm1.lastPosting.value;"><?php echo $xArea->getName()?></a> <em>(<?php echo $xArea->getNbProduct()?>)</em> </li>
          <?php endforeach?>
          <?php if ($i > 4):?>
          <li class="hideShowCat"><a title="Other" class="open" href="#"><?php echo __('Other') ?></a></li>
          <?php endif?>
		  </form>
        </ul>
        <?php } ?>

      </div>
      </div>
      <!--fiter-cats-->
    </div>
    <div class="">
    
    </div>
  </div>
  <!--box-->
  <?php endif; ?>
  <?php foreach($filter_attributes as $filter_attribute):
    $browseParams['attributeId'] = $filter_attribute->getId();
    $attribute_values = $av_table->getValues($browseParams);
	?>
  <?php if( in_array($filter_attribute->getName(), $filterAttributeName ) ) continue; ?>
  <div class="box boxGray">
    <div class="boxNoTitle">
      
    </div>
	
    <div class="">
      <div class="filter-cats ">
        <h4 class="boxeseffect hidebox" ><img  src="<?php echo $filter_attribute->getIs_collapse()? "/images/hide.jpg":"/images/show.jpg"; ?>" alt=""/> <?php echo $filter_attribute->getName()?></h4>
        <ul class="cats ulpading" style=" display: <?php echo $filter_attribute->getIs_collapse()? "none":"block"  ?> ">
          <?php 
				foreach($attribute_values as $i => $a_value):?>
          <li class="f<?php if ($i > 4) echo " hide";?>"> <a href="<?php echo url_for('@product_browse'.str_replace('&av=','&av='.$a_value->getId().'|',$queryString));?>" ><?php echo $a_value->getValue()?></a> <em>(<?php echo $a_value->getNbProduct()?>)</em></li>
          <?php endforeach?>
          <?php if ($i > 4):?>
          <li class="hideShowCat"><a title="Other" class="open" href="#"><?php echo __('Other') ?></a></li>
          <?php endif?>
          <li class="asr-v asr-md"><a href="javascript:;" id="<?php echo $filter_attribute->getId() ?>">Choose more<span> <?php echo $filter_attribute->getName() ?></span>...</a></li>
        </ul>
      </div>
      <!--fiter-cats-->
    </div>
    <div class="">
    
    </div>
  </div>
  <!--box-->
  <?php endforeach?>
</div>
<?php }else if($contentView == 'mapview'){ ?>
<div class="leftSidebar" style="width:17.3%; overflow-y: hidden; overflow-y: auto;"/>
<!-- Filterd attribute array -->
<?php $filterAttributeName = array();
 	  if($filtered_values){

    	$attributes_for_filtered_values = array();

    	foreach($filtered_values as $fvalue){
     		$attributes_for_filtered_values[$fvalue->getAttributeId()][$fvalue->getId()] = $fvalue;
    	}
 	 }
?>
<!-- End of Filterd attribute array -->

<!-- You have search -->
  <?php if($is_array_category == true || count($parent_categories) > 2 || $lastPosting || $priceRange || is_array($xAreaId) || isset($attributes_for_filtered_values)){ ?>
  <div class="box boxSidebarYellow">
	<div class="box boxHeader" style="padding-left: 0; background: none; background-color:#EC8212; width:100%;">
		<div style="background: url(/images/boxHeader_leftbg.jpg) no-repeat; width:2%; height:32px; float:left;">&nbsp;</div>
			<div style="background: url(/images/boxHeader_bg.jpg) repeat-x; min-width:95.45%;; height:32px; float:left;"><h3 style="color: #141414; float: left; font-size: 14px; font-weight: bold;line-height: 33px; margin: 0; padding: 0;"><?php echo __('You have searched') ?></h3></div>
		<div style="background: url(/images/boxHeader_rightbg.jpg) no-repeat; width:2.55%; height:32px; float:right;">&nbsp;</div>
	</div>
    <div class="">
      <ul class="cats">
          <?php foreach($customSelectedCategories as $selected_category){?>  <!-- for Categories --> 
        		<li>
          			<?php 
					 $queryStringForCategory = explode("&",$queryString);
					 unset($queryStringForCategory[0]);
					 if($is_array_category) {
						 $query_string_array_for_selected = join("&", array_diff_key($query_string_array, array($selected_category->getId() => true)));
						 unset($queryStringForCategory[1]);
						 $queryStringForCategory = $query_string_array_for_selected."&".implode("&",$queryStringForCategory);
					 } else{
					 	$queryStringForCategory = str_replace("categoryId=".$selected_category->getId(),"",implode("&",$queryStringForCategory));
					 }
	  				 echo "&nbsp;&nbsp;".link_to(" x ", "@product_browse?xType=".$xType, array("query_string" => $queryStringForCategory ));
          			 echo $selected_category->getName() ?>
        		</li>
         <?php } ?>
		
		<?php if($lastPosting){ ?>								<!-- for Last Posting --> 
				<li> &nbsp;&nbsp;&nbsp;<a href="<?php echo url_for('@product_browse'.str_replace('&lastPosting='.$lastPosting,"&lastPosting=",$queryString));?>">x</a> <?php echo "Last ".$lastPosting." days posting." ?> </li>
		<?php } ?>
		
		<?php if($priceRange && strpos($priceRange, '-') !== false){ 
				list($min_price, $max_price) = explode('-', $priceRange); ?>								<!-- for Price option --> 
			<li> &nbsp;&nbsp;&nbsp;<a href="<?php echo url_for('@product_browse'.str_replace($priceRange,"",$queryString));?>">x</a> <?php echo "Price Range ".formatPrice($min_price, $currSymbol)?> - <?php echo is_numeric($max_price) ? formatPrice($max_price, $currSymbol):__('More') ?> </li>
		<?php } ?>
		
		<?php foreach($customSelectedLocations as $selected_location){       /* for Locations */
				if($selected_location->getId() > 0){ ?>
					<li>
						<?php
						 $queryStringForLocation = explode("&",$queryString);
						 unset($queryStringForLocation[0]);
						 if($is_array_location) {
						 	 if(count($xAreaId) > 1){
								 $query_string_array_for_selected = join("&", array_diff_key($query_string_array, array($selected_location->getId() => true)));
								 unset($queryStringForLocation[2]);
								 $queryStringForLocation = $query_string_array_for_selected."&".implode("&",$queryStringForLocation);
							} else {
								unset($queryStringForLocation[2]);
								$queryStringForLocation = "xAreaId=0&".implode("&",$queryStringForLocation);
							}
						 } else{
							$queryStringForLocation = str_replace("&xAreaId=".$selected_category->getId(),"&xAreaId=0",implode("&",$queryStringForLocation));
						 }
						 echo "&nbsp;&nbsp;".link_to(" x ", "@product_browse?xType=".$xType, array("query_string" => $queryStringForLocation));
						 echo $selected_location->getName() ?>
					</li>
          <?php }
		  } ?>
		
	    <?php if(isset($attributes_for_filtered_values)){					/* for Attributes */
				foreach($attributes_for_filtered_values as $fid => $fattr){
		 		 $sattr = Doctrine::getTable('Attribute')->find($fid); ?>
				 
			     <?php foreach($fattr as $filtered_value){ ?>
							<li>  &nbsp;&nbsp;&nbsp;<a href="<?php echo url_for('@product_browse'.str_replace($filtered_value->getId(),"",$queryString));?>">x</a> <?php echo $filtered_value->getValue()?> </li>
					<?php }?>
				
		 <?php }
 			} ?>
	  </ul>
        <?php $make_clear_query['categoryId'] = "categoryId=" . $sf_user->getAttribute('clear_parent_category');?>

        <?php $make_clear_query_array_for_selected = join("&", $make_clear_query);?>

		<input type="button" value="Save search" onclick="saveSearch()"/>
    </div>
	<div id="saveSearch" style="margin-left:10px; margin-right:10px; display: none;">
		<ul class="cats">
			<li>
				Name this search : <input id="saveSearchName" type="text" name="saveSearchName" size="15"/>
			</li>
			<li>
				<input type="checkbox" id="emailDaily"/> Email me daily when new items match my search.
			</li>
				 <input type="hidden" value="" size="15"/>
				 <?php if(!$sf_user->isAuthenticated())  // set session variable.
				 		$sf_user->setAttribute('saveSearchPageUrl', $queryString); ?>
				<input id="<?php echo $sf_user->isAuthenticated()? 'saveSearchId' : 'login'; ?>" type="button" value="Save" /> <div class="loading"></div>
			
		</ul>
	</div>
	<div class="showLink">
	</div>
  </div><!--box-->
  <?php } ?>
  <!-- You have search end -->
  <?php if(count($child_categories)):?>
  <div class="box boxSidebarBlue ">
	<div class="box boxHeader catfrmt hidebox boxeseffect" style="padding-left: 0; background: none; background-color: #126FB5; width:100%;">
		<div style="background: url(/images/blueboxheaderleft.jpg) no-repeat; width:2%; height:32px; float:left;">&nbsp;</div>
			<div style="background: url(/images/blueboxheaderbg.jpg) repeat-x; min-width:94.5%;; height:32px; float:left;"><h3 style="color: #141414; float: left; font-size: 14px; font-weight: bold;line-height: 33px; margin: 0; padding: 0;"><?php echo __('Categories') ?></h3></div>
		<div style="background: url(/images/blueboxheaderright.jpg) no-repeat; width:3.5%; height:32px; float:right;">&nbsp;</div>
	</div>
    <div class="hidecategory">
      <form id="browseCategories" name="frm" action="<?php echo $is_array_category == false ? url_for('@product_browse'.$queryString): '' ?>" >
        <?php if(isset($initial_av) && $initial_av) { ?>
        			<input type="hidden" name = "av" id="av" value="<?php echo $initial_av; ?>" />
        <?php  } 
			  if($is_array_location) { 
				foreach ($xAreaId as $a_id => $a_value_id) {?>
        			<input type="hidden" name = "xAreaId[]" value="<?php echo $a_value_id; ?>" />
        <?php  }  
			  } else { ?>
        			<input type="hidden" name = "xAreaId" value="<?php echo $xAreaId; ?>" />
        <?php } ?>
					<input id="lastPostingId1" type="hidden" name = "lastPosting" value="<?php echo isset($lastPosting) ? $lastPosting : ''; ?>" />
					<input type="hidden" id="priceRangeId1" name = "priceRange" value="<?php echo isset($priceRange)? $priceRange :''; ?>" />
					<input type="hidden" name = "contentView" value="<?php echo $contentView; ?>" />
        <ul class="cats ulpading">
          <?php foreach($child_categories as $child_category):?>
          <?php if ($child_category->getIsVisible() == 0) continue;?>
          <li>
            <input type="checkbox" value="<?php echo $child_category->getId() ?>" name="categoryId[]">
            <a href="<?php echo url_for('@product_browse'.$queryString.'&categoryId='.$child_category->getId() )?>" onClick="this.href = this +'&lastPosting='+document.frm.lastPosting.value;"><?php echo $child_category->getName()?></a> <em>(<?php echo $child_category->getNbProduct()?>)</em> </li>
          <?php endforeach?>
        </ul>
		<?php //if($is_array_category == false): ?>
          <input type="submit" name="category" value="Search" class="button" style="margin:5px 0px 10px 15px; " />
        <?php //endif; ?>
		<?php if($is_array_category == true || count($parent_categories) > 2){?>
				  <a href="<?php echo url_for('@product_browse'.$queryString.'&rootCategory=1');?>" style="padding-left: 10px; text-decoration:none"><input type="button" value="Back"/></a>
		<?php } ?>
      </form>
    </div>
  </div>
  <!--box-->
  <?php endif?>
  <!--posting box-->
  <div class="box boxGray">
    <input type="hidden" id="days"/>
    <div class="">
      <div class="filter-cats  ">
        <h4 class="boxeseffect  hidebox"  ><img src="/images/show.jpg" alt=""/> <?php echo __('Last Posting') ?><span id="loading_img1"></span></h4>
        <ul class="cats ">
          <div class="demo" style="width: 85%; padding-left:18px;"> Last
            <input type="text" id="lastPostingDays" value="<?php echo isset($lastPosting)? $lastPosting : ''; ?>" size="3">
            Days posting. </div>
          <!-- End demo -->
        </ul>
      </div>
      <!--fiter-cats-->
    </div>
    <div class=""></div>
  </div>
  <!--posting box end-->
  
    <!--<div class="box boxGray">
    <div class=" boxNoTitle">
     
    </div>
    <div class="">
      <div class="filter-cats">
        <h4 class="boxeseffect hidebox"><img  src="/images/show.jpg" alt=""/> <?php echo __('Price Range') ?><span id="loading_img2"></span></h4>
		<ul class="cats ">
		<div align="center" style="padding-left:40px;"><input name="priceRange" type="text" id="amount" style="border:0; color:#FF6803; background:#F1F1F1; font-weight:bold; " /></div>
		<div style="padding-left:15px;"><div class="slid"  style="width:205px;"  id="slider-range"></div></div>
        <?php  
				// Preper a query string for price.
			/*	$queryStrForPrice = explode('&',$queryString); 
				unset($queryStrForPrice[0]); 
				$queryStringForPrice = implode('&',$queryStrForPrice); */
		?>
		</ul>    
     </div>
    </div>
    <div class="">
     
    </div>
  </div>
-->
  
  <!-- Price Range -->
  <?php if ($priceRange && strpos($priceRange, '-') !== false):?>
  <?php list($min_price, $max_price) = explode('-', $priceRange); ?>
  <?php $query_string = join("&", array_diff_key($query_string_array, array('priceRange' => true)));?>
  <?php endif?>
  <?php if (isset($price_values) && count($price_values) > 1) { ?>
  <div class="box boxGray">
    <div class=" boxNoTitle">
     
    </div>
    <div class="">
      <div class="filter-cats ">
        <h4 class="boxeseffect hidebox"><img  src="/images/show.jpg" alt=""/> <?php echo __('Price') ?></h4>
        <?php  
				// Preper a query string for price.
				$queryStrForPrice = explode('&',$queryString); 
				unset($queryStrForPrice[0]); 
				$queryStringForPrice = implode('&',$queryStrForPrice); 
		?>
        <ul class="cats ulpading">
          <li class="f"> 
		  	<div style="width:100px;"> Min :
           		<input type="text" id="bpricemin" size="6" />
			</div>
			<div style="width:105px;"> Max :
            	<input type="text" id="bpricemax" size="6" />
			</div>
		  </li>
		  <li>
            <input type="submit" value="Search" id="bpricesearch" />
          </li>
        </ul>
      </div>
    </div>
    <div class="">
     
    </div>
  </div>
  <?php } else if($priceRange && strpos($priceRange, '-') !== false){ ?>
  <div class="box boxGray">
    <div class=" boxNoTitle">
      
    </div>
    <div class="">
      <div class="filter-cats ">
        <h4 class="boxeseffect hidebox"><img src="/images/show.jpg" alt=""/> <?php echo __('Price') ?></h4>
        <ul class="cats ulpading">
          <li class="f"> <a href="<?php echo url_for('@product_browse'.str_replace($priceRange,"",$queryString));?>">x</a> <?php echo formatPrice($min_price, $currSymbol)?> - <?php echo is_numeric($max_price) ? formatPrice($max_price, $currSymbol):__('More') ?> </li>
        </ul>
      </div>
    </div>
    <div class="">
   
    </div>
  </div>
  <?php } ?>
  <!-- Price Range -->

<?php
   $queryStrForChooseMore = explode('&',$queryString); 
   unset($queryStrForChooseMore[0]); 
   $query_string_array_for_script = implode('&',$queryStrForChooseMore);
 ?>
  <?php if(isset($attributes_for_filtered_values)): ?>
  <?php foreach($attributes_for_filtered_values as $fid => $fattr): ?>
  <?php $sattr = Doctrine::getTable('Attribute')->find($fid); ?>
  <div class="box boxGray">
    <div class=" boxNoTitle">
      
    </div>
    <div class="">
      <div class="filter-cats ">
        <h4 class="boxeseffect hidebox"> <img src="/images/show.jpg" alt=""/> <?php echo $sattr->getName() ;
				$filterAttributeName[$fid] = $sattr->getName();
			
		 ?></h4>
        <ul class="cats ulpading">
          <?php foreach($fattr as $filtered_value): ?>
          <li class="f"> <a href="<?php echo url_for('@product_browse'.str_replace($filtered_value->getId(),"",$queryString));?>">x</a> <?php echo $filtered_value->getValue()?> </li>
          <?php endforeach;?>
          <li class="asr-v asr-md"><a href="javascript:;" id="<?php echo $filtered_value->getAttributeId() ?>">Choose more<span> <?php echo $filtered_value->getAttributeName() ?></span>...</a></li>
        </ul>
      </div>
      <!--fiter-cats-->
    </div>
    <div class="">
    
    </div>
  </div>
  <?php endforeach;?>
  <?php endif; ?>
  <!-- xareas -->
  <?php if(count($xAreas)):?>
  <div class="box boxGray">
    <div class=" boxNoTitle">
      
    </div>
    <div class="">
      <div class="filter-cats locationboxeffect ">
       <h4 class="hidebox hidecatbox" ><img src="/images/show.jpg" alt=""/> <?php echo __('Locations') ?></h4>
		<div>
        <?php //LNA 14.06.2011 ?>
        <?php 
		if ($xAreaId != 0){ ?>
        <form id="browseLocations" name="frm1" action="<?php echo $is_array_location == false ? url_for('@product_browse'): '' ?>" >
          <?php if($is_array_category) { 
				 foreach ($category_id as $c_id => $c_value_id) {?>
          			<input type="hidden" name = "categoryId[]" value="<?php echo $c_value_id; ?>" />
          <?php  }  
				} else { ?>
          			<input type="hidden" name = "categoryId" value="<?php echo $category_id; ?>" />
          <?php } 
		 		if(isset($initial_av) && $initial_av) { ?>
          			<input type="hidden" name = "av" id="av" value="<?php echo $initial_av; ?>" />
          <?php } ?>
          			<input type="hidden" id="priceRangeId2" name = "priceRange" value="<?php echo isset($priceRange)? $priceRange:''; ?>" />
		  			<input id="lastPostingId2" type="hidden" name = "lastPosting" value="<?php echo isset($lastPosting) ? $lastPosting : ''; ?>" />
					<input type="hidden" name = "contentView" value="<?php echo $contentView; ?>" />
          <ul class="cats ulpading">
            <?php foreach($xAreas as $i => $xArea):?>
            <li class="f<?php if ($i > 4) echo " hide";?>">
              <label class="hand">
              <input type="checkbox" name="xAreaId[]" value="<?php echo $xArea->getId(); ?>" />
              <?php echo $xArea->getName()?></label>
              <em>(<?php echo $xArea->getNbProduct()?>)</em> </li>
            <?php endforeach?>
            <?php if ($i > 4):?>
            <li class="hideShowCat"><a title="Other" class="open" href="#"><?php echo __('Other') ?></a></li>
            <?php endif?>
          </ul>
		  <input type="submit" name="location" value="Search" class="button" style="margin:5px 0px 10px 15px; ">
          <a href="<?php echo url_for('@product_browse'.$queryString.'&rootLocation=1');?>" style="padding-left: 10px; text-decoration:none"><input type="button" value="Back"/><?php //echo __('clear'); ?></a>
        </form>
        <?php

        }else{

		?>
        <ul class="cats ulpading">
		  <form id="browseLocations" name="frm1" action="<?php echo $is_array_location == false ? url_for('@product_browse?xType='.$xType): '' ?>" >
		  <input id="lastPostingId3" type="hidden" name = "lastPosting" value="<?php echo isset($lastPosting) ? $lastPosting : ''; ?>" />
		  <input id="priceRangeId3" type="hidden" name = "priceRange" value="<?php echo isset($priceRange)? $priceRange : ''; ?>" />
          <?php foreach($xAreas as $i => $xArea): ?>
          <li class="f<?php if ($i > 4) echo " hide";?>"> <a href="<?php echo url_for('@product_browse'.str_replace('&xAreaId=0',"&xAreaId[]=".$xArea->getId(),$queryString) );?>" onClick="this.href = this +'&lastPosting='+document.frm1.lastPosting.value;"><?php echo $xArea->getName()?></a> <em>(<?php echo $xArea->getNbProduct()?>)</em> </li>
          <?php endforeach?>
          <?php if ($i > 4):?>
          <li class="hideShowCat"><a title="Other" class="open" href="#"><?php echo __('Other') ?></a></li>
          <?php endif?>
		  </form>
        </ul>
        <?php } ?>

      </div>
      </div>
      <!--fiter-cats-->
    </div>
    <div class="">
    
    </div>
  </div>
  <!--box-->
  <?php endif; ?>
  <?php foreach($filter_attributes as $filter_attribute):
    $browseParams['attributeId'] = $filter_attribute->getId();
    $attribute_values = $av_table->getValues($browseParams);
	?>
  <?php if( in_array($filter_attribute->getName(), $filterAttributeName ) ) continue; ?>
  <div class="box boxGray">
    <div class="boxNoTitle">
      
    </div>
	
    <div class="">
      <div class="filter-cats ">
        <h4 class="boxeseffect hidebox" ><img  src="<?php echo $filter_attribute->getIs_collapse()? "/images/hide.jpg":"/images/show.jpg"; ?>" alt=""/> <?php echo $filter_attribute->getName()?></h4>
        <ul class="cats ulpading" style=" display: <?php echo $filter_attribute->getIs_collapse()? "none":"block"  ?> ">
          <?php 
				foreach($attribute_values as $i => $a_value):?>
          <li class="f<?php if ($i > 4) echo " hide";?>"> <a href="<?php echo url_for('@product_browse'.str_replace('&av=','&av='.$a_value->getId().'|',$queryString));?>" ><?php echo $a_value->getValue()?></a> <em>(<?php echo $a_value->getNbProduct()?>)</em></li>
          <?php endforeach?>
          <?php if ($i > 4):?>
          <li class="hideShowCat"><a title="Other" class="open" href="#"><?php echo __('Other') ?></a></li>
          <?php endif?>
          <li class="asr-v asr-md"><a href="javascript:;" id="<?php echo $filter_attribute->getId() ?>">Choose more<span> <?php echo $filter_attribute->getName() ?></span>...</a></li>
        </ul>
      </div>
      <!--fiter-cats-->
    </div>
    <div class="">
    
    </div>
  </div>
  <!--box-->
  <?php endforeach?>
</div>
<?php } ?>
<!--contentColumn-->
<?php
	// parameters send to _Browse templete. 	
	$queryStringArray = explode('&',$queryString);
	unset($queryStringArray[0]); ?>
<div class="contentColumn" id="resultSet" style=" <?php echo $contentView == 'mapview'? 'width:82.7%;':'' ?>">
  <?php if($contentView == 'listview')
   			include_partial('browse', array('category' => $category, 'pager' => $pager, 'sortType' => $sortType, 'xType' => $xType, 'viewType' => $viewType, 'query_string_array' => $queryStringArray));
		else if($contentView == 'mapview'){?>
			<div><div class="tabs"></div><div class="arrowImage"></div><div id="map" style=""></div></div>
			<div id="login_form_container" class="login-dialog"></div>
		<?php }
	?>
</div>
<!--contentColumn-->
<br/>
<div class="clear"></div>
<br/>
<div id="choose_more_form_container" class="agreement-dialog ds_oly"></div>
<script type="text/javascript">
  //$("#saveSearch").hide();
  
  var contentView = "<?php echo $contentView; ?>";
  $(document).ready( function() {
	//alert($("#resultSet").offset().top);
  	if(contentView == 'mapview'){
	    $.noConflict();
	    var sideBarWidth = 246 + 17;
	    //$(".leftSidebar").css('width',sideBarWidth);
	    var sideBarHeight = parseInt(getWindowHeight()) - 40;//53; 
	    $(".leftSidebar").css('height',sideBarHeight);
	    var windowheight = parseInt(getWindowHeight()) - 50;//68;
	    //var windowwidth = parseInt(getWindowWidth()) - 265;//275;
	    // Map js
		$("#map").css({
			height: windowheight//, //505,
			//width: windowwidth
		});
		var myLatLng = new google.maps.LatLng(<?php echo isset($avr_lat)? $avr_lat:0; ?>, <?php echo isset($avr_lng)? $avr_lng:0; ?>); 
		MYMAP.init('#map', myLatLng, 3);
		MYMAP.placeMarkers(<?php echo isset($initial_data)? $initial_data:0; ?>);
        //
	}
    <?php if ($category->isComparable()):?>

    $(".compare-hide").show();

    <?php endif?>

    $('#sortType').bind('change', function(){

      var query_string = "<?php echo join("&", $queryStringArray)?>";

      window.location = '<?php echo url_for("@product_browse?xType=".$xType)?>'+ '?' + query_string + "&sortType=" + $(this).val();

    });	
	
	function isNumeric(value) {
	  if (value == null || !value.toString().match(/^[-]?\d*\.?\d*$/)) return false;
	  return true;
	}
	
	$('#lastPostingDays').live('keyup', function() {
		var daySpan = $( "#lastPostingDays" ).val();
	/*	
		$.ajax({
				   type: 'GET',
				   url : '../product/browse',
				   data: 'getHtmlTemplate=yes&id=290&img=/uploads/product-image-2/s_87a9c80e91fe1e51dd64da3fdde287a7.jpg',
				   success:function(msg){
				   		$('#resultSet').html(msg);
						//infoWindow.setContent(msg);
						//infoWindow.open(MYMAP.map, marker);
				   }	  
			}); return false;
	*/	
		if((isNumeric(daySpan) && daySpan > 0  && daySpan != 0) || daySpan == '' ) {

			var url  = '../product/browse';
			var query_string = "<?php echo $queryString; ?>";
			var xType = "<?php echo $xType; ?>";
			if(daySpan < 0){
				alert("Please enter numeric value greater than 0.");
				return false;
			}
			if(daySpan == '')
				daySpan = -1 ;
			postData = query_string+'&xType='+xType+'&lastPosting='+daySpan;
			$.ajax({
			   type: 'POST',
			   url : url,
			   data: postData,
			   beforeSend:function(){
			   	if(contentView == 'listview')
					$("#resultSet").html('<center><img src="/images/loading_gif.gif" border="0" id="limg" alt="loading..." /></center>');
				else
					$('#loading_img1').html('&nbsp;&nbsp;<img id="rset" src="/images/loading_img.gif">');
			   },
			   success:function(msg){
				$('#lastPostingId1').val(daySpan);
				$('#lastPostingId2').val(daySpan);
				$('#lastPostingId3').val(daySpan);
				$('#lastPostingId4').val(daySpan);
				if(contentView == 'listview'){
					$('#resultSet').html(msg);
					$('table.table-list-view tr:odd:not(.list-title, .featured)').addClass('even');
    				$('table.table-list-view tr:even:not(.list-title, .featured)').addClass('odd');
				} else {
					removeMarker();
					try{
						MYMAP.placeMarkers(jQuery.parseJSON(msg));
						$('#loading_img1').html('');
					} catch(e) { alert('Error in loading map!...'+e);}
				}
			  }	  
		   }); // Ajax closing
		} else {
			if(daySpan == '0')
				alert("Please enter numeric value greater than 0.");
			else if(daySpan == ''){}
			else
				alert("Please enter numeric value.");
		}
    });
	
	$('#bpricesearch').click(function(){
	  var minPrice = $('#bpricemin').val();
	  var maxPrice = $('#bpricemax').val();
      if(minPrice == ''){
	  	alert("Enter minimum price range."); return false;
	  }
	  if(!isNumeric(minPrice) || !isNumeric(maxPrice)){
	  	alert("Enter numeric price range value."); 
		isNumeric(maxPrice)? '' : $('#bpricemax').val("");
		isNumeric(minPrice)? '' : $('#bpricemin').val("");
		return false;
	  }
	  if(minPrice < 0 || maxPrice < 0){
	  	alert("Enter positive numeric price range values."); 
		parseFloat(maxPrice) < 0 ? $('#bpricemax').val(""):'';
		parseFloat(minPrice) < 0 ? $('#bpricemin').val(""):'';
		return false;
	  }
	  if($('#bpricemax').val() != ''){
	  	if(parseFloat($('#bpricemax').val()) < parseFloat($('#bpricemin').val())){
	    	alert("Enter proper price range."); $('#bpricemax').val("");
			return false;
		}
	  }
	  var query_string = "<?php echo isset($queryStringForPrice)? $queryStringForPrice : ''; ?>";
	  if($("#lastPostingDays").val())
	  	query_string = query_string+"&lastPosting="+$("#lastPostingDays").val();
      var priceRangeValue = encodeURIComponent($('#bpricemin').val())+"-"+encodeURIComponent($('#bpricemax').val());
	  query_string = query_string.replace("&priceRange=", "&priceRange="+priceRangeValue);
	  //alert(query_string);
      window.location = '<?php echo url_for("@product_browse?xType=".$xType)?>'+ '?' + query_string;

      return false;

    });

	
    //filter page table

    $('table.table-list-view tr:odd:not(.list-title, .featured)').addClass('even');

    $('table.table-list-view tr:even:not(.list-title, .featured)').addClass('odd');

<?php if ($category->isComparable()):?>

    //filter PAGE compare

    productCompare.categoryId = <?php echo $category->getId()?>;

    eval("var compareValues = "+(cookieManager.getCookie("compareValues") || '{categoryId:0,items:{}}')+";");

    //var compareItems = new compareProductItem();

    if (productCompare.categoryId == compareValues.categoryId){

      productCompare.compareItems.setItems(compareValues.items);

    } else {

      cookieManager.setCookie('compareValues', "{categoryId:0,items:{}}");

    }

    //binding

    $('.compare-select').click(function(){

      var element = $(this);

      if (element.attr('checked')) {

        if (productCompare.compareItems.getLength() < 5){

          productCompare.compareItems.addItem(element.val(), element.siblings('img').attr('src'));

        } else {

          alert('<?php echo __('You can compare 5 products as maximum')?>');

          element.attr('checked', false);

        }

      } else { //removing

        productCompare.compareItems.deleteItem(element.val());

      }

      cookieManager.setCookie('compareValues', "{categoryId:"+productCompare.categoryId+",items:"+productCompare.compareItems.serialize()+"}");

      productCompare.bindCompareItems();

    });
    productCompare.bindCompareItems();

<?php endif?>

    Yozoa.Browse.initialize({
        'DIV': 'choose_more_form_container',
        'query_string': "<?php echo $query_string_array_for_script ?>"

    });
	
  });
  
  // hide & show Category div
	   $(".hidebox").click(function () {
		   $(this).next(".hidecategory").toggle("fast"); 
		});
	
 // hide & show Other all Attributes rather than Locations			
	   $(".boxeseffect").click(function () {
		  $(this).next("ul").toggle("fast");
			hidenshow(this);
		});

// hide & show Locations div.		
	   $(".hidecatbox").click(function () {
		 $(this).next("div").toggle("fast");
			hidenshow(this);
		});
	
//function for Hide n Show Image.			
		function hidenshow(id){
			      if ($(id).children("img").attr('src')=='/images/hide.jpg')
				     $(id).children("img").attr('src','/images/show.jpg')
			 else if ($(id).children("img").attr('src')=='/images/show.jpg')
			 		 $(id).children("img").attr('src','/images/hide.jpg');
							  }
// hover effect...								
  	   $(".hidebox").mouseover(function () {
		   $(this).parent("div").addClass("focuseffect");
		   $(this).parent("div").removeClass("box");
			});	
	   $("div").mouseout(function () {
			  $(this).addClass("box");
			  $(this).removeClass("focuseffect");
			  $(this).children("h4").toggleClass("box");
			});	//Left panel hover effect	
			
								
		
  function saveSearch(){
     $("#saveSearch").show();
  }
  
  $('#saveSearchId').click(function(){
	  var searchName = $("#saveSearchName").val();
	  var emailDaily = $('#emailDaily').is(':checked');
	  
	  if(searchName != '' ) {

		var query_string = "<?php echo str_replace("=","#",str_replace("&","*",$queryString)); ?>";
		var xType = "<?php echo $xType; ?>";
		postData = "queryString="+query_string+'&xType='+xType+'&saveSearchName='+searchName+'&emailDaily='+emailDaily;
		//alert(postData);
	    var url  = '../product/sendEmailOfSavedSearch';	  
	    $.ajax({
		   type: 'POST',
		   url : url,
		   data: postData,
		   /*beforeSend:function(){
			 //$(".loading").html('<img src="/images/Tab_Loading.gif" border="0" id="limg" alt="loading..." />');
		   },*/
		   success:function(msg){
		    //alert(msg);
			 $('.showLink').html(msg);
		   }	  
	   }); // Ajax closing
	 } else {
	 	alert("Please enter the search name... ");
	 }
  });
  $('#login').click(function(){
  	window.location = '../user/login';
      return false;
  });
  
    function getWindowWidth() {
	  var myWidth = 0;
	  if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		myWidth = window.innerWidth;
	  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		myWidth = document.documentElement.clientWidth;
	  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		myWidth = document.body.clientWidth;
	  }
	  return myWidth;
	}
	
    function getWindowHeight() {
	  var myHeight = 0;
	  if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		myHeight = window.innerHeight;
	  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		myHeight = document.documentElement.clientHeight;
	  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		myHeight = document.body.clientHeight;
	  }
	  return myHeight;
	}
  
/*  $(function() {
		$( "#slider-range" ).slider({
		range: true,
		min: <?php echo $minprice; ?>,
		max: <?php echo $maxprice; ?>,
		values: [<?php echo $minprice; ?>,<?php echo $maxprice; ?>],
			slide: function( event, ui ) {
			//alert(ui.value[0]);		
			when_slide(ui.values[0],ui.values[1]);		
			},
			stop: function(event, ui) {
			//$("#rset").css("display","block");
		//	when_stop(ui.values[0],ui.values[1]);	
		
			var url  = '../product/browse';
				var query_string = "<?php echo $queryString; ?>";
				var xType = "<?php echo $xType; ?>";
				var query_string = "<?php  echo isset($queryStringForPrice)? $queryStringForPrice : ''; ?>";
				if($("#lastPostingDays").val())
				query_string = query_string+"&lastPosting="+$("#lastPostingDays").val();
				var priceRangeValue = ui.values[0] + "-" + ui.values[1];
				query_string = query_string.replace("&priceRange=", "&priceRange="+priceRangeValue);
				postData = query_string;//alert(query_string); return false;
				$.ajax({
				   type: 'POST',
				   url : url,
				   data: postData,
				   beforeSend:function(){
					  if(contentView == 'listview')
						$("#resultSet").html('<center><img src="/images/loading_gif.gif" border="0" id="limg" alt="loading..." /></center>');
					  else
						$('#loading_img2').html('&nbsp;&nbsp;<img id="rset" src="/images/loading_img.gif">');
				   },
				   success:function(msg){
				   	  $('#priceRangeId1').val(priceRangeValue);
					  $('#priceRangeId2').val(priceRangeValue);
					  $('#priceRangeId3').val(priceRangeValue);
					  $('#priceRangeId4').val(priceRangeValue);
				   	  if(contentView == 'listview'){
						$('#resultSet').html(msg);
					  } else {
						removeMarker();
						try{
							MYMAP.placeMarkers(jQuery.parseJSON(msg));
							$('#loading_img2').html('');
						} catch(e) { alert('Error in loading map!...'+e);}
					  }
				   }	  
			   }); // Ajax closing
		
	
			
			},
		});
		
		function when_stop(pminval,pmaxval){*/
			/*var query_string = "<?php  echo isset($queryStringForPrice)? $queryStringForPrice : ''; ?>";
			if($("#lastPostingDays").val())
			query_string = query_string+"&lastPosting="+$("#lastPostingDays").val();
			var priceRangeValue = pminval + "-" + pmaxval;
			query_string = query_string.replace("&priceRange=", "&priceRange="+priceRangeValue);
			//alert(query_string);
			window.location = '<?php echo url_for("@product_browse?xType=".$xType)?>'+ '?' + query_string;
			*/
		/*}
	
		$( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
		" <?php echo $symbol; ?> - " + $( "#slider-range" ).slider( "values", 1 ) + " <?php echo $symbol; ?>" );
	});
	
	function when_slide(pminval,pmaxval){
		$( "#amount" ).val(pminval+ " <?php echo $symbol; ?> - " + pmaxval + " <?php echo $symbol; ?>");
	}*/
  
  if( contentView == 'mapview'){
	//Google map for Map Refine search.
	var MYMAP = {
		map: null,
		bounds: null
	}
	var usrLogin = "<?php echo $sf_user->isAuthenticated() == NULL ? '0':'1'; ?>";
	var favorite_product = [];
	MYMAP.init = function(selector, latLng, zoom) {
		var myOptions = {
			zoom:zoom,
			minZoom: 2,
    		//maxZoom: 50,
			center: latLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		this.map = new google.maps.Map($(selector)[0], myOptions);
		this.bounds = new google.maps.LatLngBounds();
	}
	function getHtmlTemplate(id,img,price,name,attr1,attr2,attr3,attr,imgColor)
	{
		var code ='<a href="#" onclick="loginDialog('+id+'); return false;">Mark as favorite</a>';
		p_price = price;
		if(usrLogin == 1){ 
			var index = -1;
			$.each(favorite_product, function(key, val){
				if(id == val)
					index = key;
			});

			if(index > -1)
				code = '<a href="#" onclick="markPoint('+id+')"><span class="lableId'+id+'">Remove mark as favorite</span></a>';
			else
				code = '<a href="#" onclick="markPoint('+id+')"><span class="lableId'+id+'">Mark as favorite</span></a>';
		}
		if(attr){
			return '<div id="myMapDiv'+id+'" style="width:330px; height:175px; overflow:hidden;"><div align="justify" style="width:321px; font-size:12px; padding: 10px 5px 0px 0px; height:30px;"> <center> <a class="blueSmall" href="../album/'+id+'" target="_blank"><b>'+name+'</b></a></center></div><div style="float:left; height:125px; width:160px;"><a href="../album/'+id+'" target="_blank"><img style="float: left; padding-left:8px;" src="'+img+'"></a></div> <div class="inline right cars-details" style=" float:right; width:165px; height:125px;"><div class="product-details" style="width: 165px; height:125px;"><ul class="details" style=" margin:0 0 0; padding: 0 0 0 0; width:165px; height:125px;"> <li class="price" style="font-size: 14px;"><span style="padding-top: 0px; width:85px;">Price</span>'+price+'</li><li> <span style="width:85px;">Property Type</span>'+attr1+'</li><li> <span style="width:85px;">Plot Area m&sup2;</span>'+attr2+'</li><li> <span style="width:85px;">Home Size m&sup2;</span>'+attr3+'</li>'+code+'<span class="loading_image"></span></ul></div></div></div>';
		}else{
			return '<div id="myMapDiv'+id+'" style="width:330px; height:175px; overflow:hidden;"><div align="justify" style="width:321px; font-size:12px; padding: 10px 5px 0px 0px; height:30px;"> <center> <a class="blueSmall" href="../album/'+id+'" target="_blank"><b>'+name+'</b></a></center></div><div style="float:left; height:125px; width:160px;"><a href="../album/'+id+'" target="_blank"><img style="float: left; padding-left:8px;" src="'+img+'"></a></div> <div class="inline right cars-details" style=" float:right; width:165px; height:125px;"><div class="product-details" style="width: 165px; height:125px;"><ul class="details" style=" margin:0 0 0; padding: 0 0 0 0; width:165px; height:125px;"> <li class="price" style="font-size: 14px;"><span style="padding-top: 0px; width:85px;">Price</span>'+price+'</li><div style=" padding-top:80px;">'+code+'<span class="loading_image"></span></div></ul></div></div></div>';
		}
	}
	var markersArray = [];
	var infobubbleArray = [];
	var openInfoBox = 0;
	var openedInfoWindow = null;
	var mouseOver = 0;
	var markerObj = null;
	var markerImg = null;
	var p_price = null;
	var symbol = "<?php echo CurrencyTable::getInstance()->getSymbol($code = isset($_SESSION['currency'])? $_SESSION['currency'] : 'NOK'); ?>";
	MYMAP.placeMarkers = function(data) {
		$.each(data, function(key, value) { 
			var id = value.id;
			// create a new LatLng point for the marker
			var lat = value.lat;
			var lng = value.lng;
			var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
			var name = value.name;
			var price = value.price;
			if(name.length > 30) {
				tooltip = name.substring(0, 30);
			}else{
				tooltip = name;
			}
			var attr = value.attrFlag;
			var attr1 = attr;
			var attr2 = attr;
			var attr3 = attr;
			if(value.attrFlag){
				attr1 = value.attrFlag1;
				attr2 = value.attrFlag2;
				attr3 = value.attrFlag3;
			}
			//var image = '/images/house1.png';
			var img = value.img;
			var imgColor = value.imgcolor;
			if(imgColor == 1)
				favorite_product.push(id);
			var icon_img = "../product/GetIconImage?price="+price+"&color="+imgColor+"&symbol="+symbol;
			var icon_img1 = "../product/GetIconImage?price="+price+"&color=3&symbol="+symbol;
			// extend the bounds to include the new point
			MYMAP.bounds.extend(point);
			
			var marker = new google.maps.Marker({
				position: point,
				map: MYMAP.map,
				title: tooltip,
				icon: icon_img,
				zIndex: 999
			});
			
			markersArray.push(marker);
			var infoBubble = new InfoBubble({
				disableAutoPan: true, 
				//hideCloseButton: true, 
				arrowPosition: 30,
				padding:0
			});
			infobubbleArray.push(infoBubble);
			google.maps.event.addListener(marker, 'click', function(e) { 
				p_price = price;
				if (openedInfoWindow != null){
					openedInfoWindow.close(); 
					openInfoBox = 0;
					openedInfoWindow = null;
					if(markerObj == marker)
						return false;
				}
				markerObj = marker;
				if (!openInfoBox){
				 	openInfoBox = 1;
					infoBubble.setContent(getHtmlTemplate(id,img,price,name,attr1,attr2,attr3,attr,imgColor));
					infoBubble.close();
					//Get marker position in pixel from map canvas.
					var scale = Math.pow(2, MYMAP.map.getZoom());
					var nw = new google.maps.LatLng(
						MYMAP.map.getBounds().getNorthEast().lat(),
						MYMAP.map.getBounds().getSouthWest().lng()
					);
					var worldCoordinateNW = MYMAP.map.getProjection().fromLatLngToPoint(nw);
					var worldCoordinate = MYMAP.map.getProjection().fromLatLngToPoint(marker.getPosition());
					var pixelOffset = new google.maps.Point(
						Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
						Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
					);
					marker.flag = 0;
					marker.arrowPos = 65;
					infoBubble.setArrowSize(15);
					var arrowPosition = 30;
					var widthofmap = $("#resultSet").width() - 241;
					if(widthofmap < pixelOffset.x){
						arrowPosition = 90;
						var total = (parseInt(pixelOffset.x) + parseInt(241)) - $("#resultSet").width();
						total = parseInt(total/241*100)+parseInt(40);
						if(total > 90)
							total = 90;
						if(total < 10)
							total = 10;
						arrowPosition = total;
					}
					if(pixelOffset.x < 100){
						arrowPosition = 10;
						if(pixelOffset.x >60)
							arrowPosition = 20;
					}
					infoBubble.setArrowPosition(arrowPosition);
					if(pixelOffset.y < 200){
						marker.flag = 1;
						arrowPosition = parseInt(95 - parseInt(arrowPosition));
						marker.arrowPos = arrowPosition;
						infoBubble.setArrowSize(0);
					}
					infoBubble.open(MYMAP.map, marker);
					openedInfoWindow = infoBubble;
				}
				google.maps.event.addListener(infoBubble, 'closeclick', function() {
					openedInfoWindow = null;
					openInfoBox = 0;
				});
			});
			
			MYMAP.map.fitBounds(MYMAP.bounds);
		});
	}

	function removeMarker() {
		if (markersArray) {
			for (i=0; i < markersArray.length; i++) {
				markersArray[i].setMap(null);
			}
		}
	}
	function markPoint(id){
		var count = 0,index = -1;
		$.each(favorite_product, function(key, val){
			count+=1; 
		 	if(id == val)
		 		index = key;
		});
		$.ajax({
			   type: 'GET',
			   url : '../product/browse',
			   data: 'setFavorite=yes&id='+id,
			   beforeSend:function(){
					$('.loading_image').html('&nbsp;&nbsp;<img id="rset" src="/images/loading_img.gif">');
			   },
			   success:function(msg){
			   		$('.loading_image').html('');
					if($('.lableId'+id).html() == 'Remove mark as favorite'){
						favorite_product.splice(index, 1);
						$('.lableId'+id).html('Mark as favorite');
						markerImg = "../product/GetIconImage?price="+p_price+"&color=2&symbol="+symbol;
						markerObj.setIcon(markerImg);
					}else if($('.lableId'+id).html() == 'Mark as favorite'){
						favorite_product.push(id);
						$('.lableId'+id).html('Remove mark as favorite');
						markerImg = "../product/GetIconImage?price="+p_price+"&color=1&symbol="+symbol;
						markerObj.setIcon(markerImg);
					}
			   }	  
		});
	}
	function loginDialog(productId)
    {
        $('.login-dialog').dialog('close');
        $('#login_form_container').load('/user/loginForm?mapView=yes').dialog({
            title:  'You need to login before proceeding',
            autoOpen: false,
            resizable: false,
            width: 490,
            autoResize : true

        });
        $('.login-dialog').dialog('open');
        return false;
    }
  }

</script>
