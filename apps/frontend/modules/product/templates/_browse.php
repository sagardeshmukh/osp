<?php include_partial('banner/show', array("categoryId"=>$sf_user->getAttribute('clear_parent_category')))?>

<div class="tabs">
  <?php if($category->isComparable() && $xType != 'jobs'):?>	<!-- check the xType & apply compare functionality. -->
  <ul class="compare-ul">
    <li class="compare-li"></li>
    <li class="compare-li"></li>
    <li class="compare-li"></li>
    <li class="compare-li"></li>
    <li class="compare-li"></li>
    <li><a href="#" onclick="productCompare.gotoCompare('<?php echo $sf_user->getCulture()?>'); return false;" class="compare-link"><?php echo __('Compare') ?></a></li>
  </ul>
  <input type="hidden" id="compare_ids" name="compare_ids" value="" />
  <?php endif?>
</div>
<div class="searchView">
  <div class="left"> <?php echo __('Total') ?> <?php echo $pager->getNbResults()?>. &nbsp;&nbsp; <?php echo __('Sort') ?>
    <?php
	  // Check Sort Type options & unset sort on price for job section. 
	  $SortTypesOptionArray = Product::getSortTypes();
	  if($xType == 'jobs'){
		  unset($SortTypesOptionArray['price_asc']);
		  unset($SortTypesOptionArray['price_desc']);
	  }
      $sortTypeWidget = new sfWidgetFormSelect(array('choices' => $SortTypesOptionArray))?>
    <?php echo $sortTypeWidget->render('sortType', $sortType)?> </div>
  <?php if($xType != 'jobs'){ ?>
  <div id="search-view">
    <ul>
      <li class="lbl"><?php echo __('View') ?></li>
      <li class="gallery"><a href="<?php echo url_browse("@product_browse?xType=".$xType, $query_string_array, "viewType" , "viewType=grid")?>" class="<?php if ($viewType == "grid") echo "active"?>"><span>Grid</span></a></li>
      <li class="list"><a href="<?php echo url_browse("@product_browse?xType=".$xType, $query_string_array, "viewType" , "viewType=list")?>" class="<?php if ($viewType == "list") echo "active"?>"><span>List</span></a></li>
    </ul>
  </div>
  <?php } ?>
</div>
<?php if($pager->getNbResults()):?>
<?php if($xType == 'jobs'): ?>
<table cellspacing="1" cellpadding="3" border="0" class="table-list-view">
  <tbody valign="top">
    <tr class="list-title">
      <td>&nbsp;</td>
      <td><a href="#"><?php echo __('Position') ?></a></td>
      <td><a href="#"><?php echo __('Company') ?></a></td>
      <td><a href="#"><?php echo __('Location/Deadline') ?></a></td>
    </tr>
    <?php foreach($pager->getResults() as $product):?>
    <?php //echo "[" . $product->getDuration() . "]"; ?>
    <?php include_partial('jobListRow', array('product' => $product)) ?>
    <?php endforeach;?>
  </tbody>
</table>
<?php elseif ($viewType == "list"):?>
<table cellspacing="1" cellpadding="3" border="0" class="table-list-view">
  <tr class="list-title">
    <td>&nbsp;</td>
    <td><a href="#"><?php echo __('Ad title') ?></a></td>
    <td><a href="#"><?php echo __('Price') ?></a></td>
    <td><a href="#"><?php echo __('Time left') ?></a></td>
  </tr>
  <?php foreach($pager->getResults() as $product):?>
  <?php include_partial('listItem', array(

                  'product'     => $product,

                  'sf_cache_key'=> $product->getCacheKey()));?>
  <?php endforeach;?>
</table>
<?php elseif($xType == 'cars'): ?>
<div class="clear"></div>
<div class="div-gallery-view">
  <?php

        	$results    = $pager->getResults();

	        $nb_product = count($results);

        ?>
  <?php for($i = 0; $i < $nb_product; $i = $i + 2):?>
  <div class="row">
    <?php include_partial('carItem', array('product'=>$results[$i],'sf_cache_key'=> $results[$i]->getCacheKey()));?>
    <?php if (isset($results[$i+1])) include_partial('carItem', array('product'=>$results[$i+1],'sf_cache_key'=> $results[$i]->getCacheKey()))?>
  </div>
  <div class="hr clear" style="border-style: none none none;">
    <hr />
  </div>
  <?php endfor;?>
  <div class="clear"></div>
</div>
<?php elseif($xType == 'realestates'): ?>
<div class="clear"></div>
<div class="div-gallery-view">
  <?php

        	$results    = $pager->getResults();

	        $nb_product = count($results);

        ?>
  <?php for($i = 0; $i < $nb_product; $i = $i + 2):?>
  <div class="row">
    <?php include_partial('realestatesItem', array('product'=>$results[$i],'sf_cache_key'=> $results[$i]->getCacheKey()));?>
    <?php if (isset($results[$i+1])) include_partial('realestatesItem', array('product'=>$results[$i+1],'sf_cache_key'=> $results[$i]->getCacheKey()))?>
  </div>
  <div class="hr clear" style="border-style: none none none;">
    <hr />
  </div>
  <?php endfor;?>
  <div class="clear"></div>
</div>
<?php else:?>
<div class="clear"></div>
<div class="div-gallery-view">
  <?php

        $results    = $pager->getResults();

        $nb_product = count($results);

        ?>
  <?php for($i = 0; $i < $nb_product; $i = $i + 2):?>
  <div class="row">
    <?php include_partial('gridItem', array('product'=>$results[$i],'sf_cache_key'=> $results[$i]->getCacheKey()));?>
    <?php if (isset($results[$i+1]))
	
				  include_partial('gridItem', array('product'=>$results[$i+1],'sf_cache_key'=> $results[$i]->getCacheKey()))?>
  </div>
  <div class="hr clear" style="border-style: none none none;">
    <hr />
  </div>
  <?php endfor;?>
  <div class="clear"></div>
</div>
<!--div-gallery-view-->
<div class="clear"></div>
<?php endif;?>
<?php // LNA - get initial av for pagination ?>
<?php if(isset($initial_av) && $initial_av != '') $query_string_array['av'] = "av=" . $initial_av; ?>
<div class="pagenav">
  <div class="pagenavWrap"> <?php echo pager_navigation($pager, url_for("@product_browse?xType=".$xType)."?".join("&", $query_string_array))?> </div>
</div>
<!--pagenav-->
<?php endif;?>
