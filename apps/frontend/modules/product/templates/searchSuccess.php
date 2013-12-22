<div class="bread-crumb">

    <a href="<?php echo url_for('@homepage')?>" class="home" style="z-index:100;"></a>

    <?php $z_index = 99;?>



    <?php if (isset($category)):?>

    <span style="z-index: <?php echo  $z_index--?>;">

        <?php echo __('Category') ?> : <?php echo $category->getName()?>

            <?php echo link_to("x", "@product_search", array("query_string" => "keyword={$keyword}"))?>

    </span>

    <?php endif?>



    <?php if ($priceRange && strpos($priceRange, '-') !== false):?>

        <?php list($min_price, $max_price) = explode('-', $priceRange); ?>

    <span style="z-index: <?php echo  $z_index--?>;">

        <?php echo __('Price')?>: <?php echo $min_price?> - <?php echo is_numeric($max_price) ? $max_price:__('More') ?>

            <?php $query_string = join("&", array_diff_key($query_string_array, array('squareRange' => true)));?>

            <?php echo link_to("x", "@product_search", array("query_string" => $query_string))?>

    </span>

    <?php endif?>



    <!-- realEstate square range -->

    <?php if ($squareRange && strpos($squareRange, '-') !== false):?>

        <?php list($min_square, $max_square) = explode('-', $squareRange); ?>

    <span style="z-index: <?php echo  $z_index--?>;">

        <?php echo __('Square')?>: <?php echo $min_square?> - <?php echo is_numeric($max_square) ? $max_square:__('More') ?>

            <?php $query_string = join("&", array_diff_key($query_string_array, array('priceRange' => true)));?>

            <?php echo link_to("x", "@product_search", array("query_string" => $query_string))?>

    </span>

    <?php endif; ?>



    <?php foreach($filtered_values as $filtered_value): $z_index--?>

    <span style="z-index: <?php echo $z_index?>;">

            <?php echo $filtered_value->getAttributeName()." :".$filtered_value->getValue()?>

            <?php $query_string = join("&", array_diff_key($query_string_array, array($filtered_value->getId() => true)));?>

            <?php echo link_to("x", "@product_search", array("query_string" => $query_string))?>

    </span>

    <?php endforeach;?>



    <span style="z-index: <?php echo $z_index--?>;">

        <?php echo __('Keyword') ?> : <?php echo $keyword?>

    </span>

</div>

<div class="leftSidebar">

    <?php if(count($child_categories)):?>

    <div class="box boxSidebarBlue">

        <div class="boxHeader"><div><h3><?php echo __('Categories') ?></h3></div></div>

        <div class="boxContent">

            <ul class="cats">

              <?php foreach($child_categories as $child_category):?>

                <li>

                    <a href="<?php echo url_browse("@product_search", $query_string_array, 'categoryId' , "categoryId={$child_category->getId()}")?>">

                         <?php echo $child_category->getName();?>

                    </a>

                    <em>(<?php echo $child_category->getNbProduct()?>)</em>

                </li>

              <?php endforeach?>

            </ul>

        </div>

        <div class="boxFooter"><div></div></div>

    </div><!--box-->

    <?php endif?>





    <?php if (isset($price_values) && count($price_values) > 1):?>

    <div class="box boxGray">

        <div class="boxHeader boxNoTitle"><div></div></div>

        <div class="boxContent">

            <div class="filter-cats">

                <h4><?php echo __('Price')?></h4>

                <ul class="cats">

                        <?php foreach($price_values as $i => $value):?>

                    <li class="f<?php if ($i > 4) echo " hide";?>">

                        <a href="<?php echo url_browse("@product_search", $query_string_array, 'priceRange' , "priceRange={$value['min']}-{$value['max']}")?>">

                                    <?php echo $value['min']?> - <?php echo is_numeric($value['max']) ? $value['max']: __('More') ?>

                        </a>

                        <em>(<?php echo $value['nb_product']?>)</em>

                    </li>

                        <?php endforeach?>

                        <?php if ($i > 4):?>

                    <li class="hideShowCat"><a title="Other" class="open" href="#"><?php echo __('Other') ?></a></li>

                        <?php endif?>

                </ul>

            </div><!--fiter-cats-->

        </div>

        <div class="boxFooter"><div></div></div>

    </div><!--box-->

    <?php endif?>



    <?php if (isset($search_attributes)):?>

        <?php foreach($search_attributes as $search_attribute):?>

            <?php $attribute_values = Doctrine::getTable('AttributeValues')->getSearchValues($category->getId(),

                    $xAreaId,

                    $search_attribute->getId(),

                    $rAttributeValueIds,

                    $oAttributeValueIds,

                    $keywords,

                    $priceRange)?>

            <?php if (count($attribute_values) == 1) continue;?>

    <div class="box boxGray">

        <div class="boxHeader boxNoTitle"><div></div></div>

        <div class="boxContent">

            <div class="filter-cats">

                <h4><?php echo $search_attribute->getName()?></h4>

                <ul class="cats">

                            <?php foreach($attribute_values as $i => $a_value):?>

                    <li class="f<?php if ($i > 4) echo " hide";?>"><a href="<?php echo url_browse("@product_search", $query_string_array, $a_value->getId() , "av[]={$a_value->getId()}")?>"><?php echo $a_value->getValue()?></a> <em>(<?php echo $a_value->getNbProduct()?>)</em></li>

                            <?php endforeach?>

                            <?php if ($i > 4):?>

                    <li class="hideShowCat"><a title="Other" class="open" href="#"><?php echo __('Other') ?></a></li>

                            <?php endif?>

                </ul>

            </div><!--fiter-cats-->

        </div>

        <div class="boxFooter"><div></div></div>

    </div><!--box-->

        <?php endforeach?>

    <?php endif?>



</div><!--sidebar-->





<div class="contentColumn">



    <?php //include_partial('banner/show', array("categoryId"=>$sf_params->get("categoryId")))?>



    <div class="tabs">

    </div>

    <div class="searchView">

        <div class="left">

	  <?php echo __('Total') ?> <?php echo $pager->getNbResults()?>. &nbsp;&nbsp; <?php echo __('Sort') ?>

            <?php

            $sortTypeWidget = new sfWidgetFormSelect(array('choices' => Product::getSortTypes()))?>

            <?php echo $sortTypeWidget->render('sortType', $sortType)?>

        </div>

        <div id="search-view">

            <ul>

                <li class="lbl"><?php echo __('View') ?></li>

                <li class="gallery"><a href="<?php echo url_browse("@product_search", $query_string_array, "viewType" , "viewType=grid")?>" class="<?php if ($viewType == "grid") echo "active"?>"><span>Grid</span></a></li>

                <li class="list"><a href="<?php echo url_browse("@product_search", $query_string_array, "viewType" , "viewType=list")?>" class="<?php if ($viewType == "list") echo "active"?>"><span>List</span></a></li>

            </ul>

        </div>

    </div>

    <div class="clear"></div>

    <?php if($pager->getNbResults()):?>

    <?php if($xType == 'jobs'): ?>

    <table cellspacing="1" cellpadding="3" border="0" class="table-list-view">

    <tbody valign="top">

    <tr class="list-title">

      <td>&nbsp;</td>

      <td><a href="#"><?php echo __('Position') ?></a></td>

      <td><a href="#"><?php echo __('Company') ?></a></td>

      <td><a href="#"><?php echo __('Salary') ?></a></td>

      <td><a href="#"><?php echo __('Location/Deadline') ?></a></td>

    </tr>

    <?php foreach($pager->getResults() as $product):?>

    <?php include_partial('jobListRow', array('product' => $product)) ?>

    <?php endforeach;?>

    </tbody>

    </table>



        <?php elseif ($viewType == "list"):?>

    <table cellspacing="1" cellpadding="3" border="0" class="table-list-view">

        <tr class="list-title">

            <td>&nbsp;</td>

            <td><a href="#"><?php echo __('Title') ?></a></td>

            <td><a href="#"><?php echo __('Price') ?></a></td>

            <td><a href="#"><?php echo __('Time left') ?></a></td>

        </tr>

                <?php foreach($pager->getResults() as $product):?>

                    <?php include_partial('listItem', array(

                            'product'     => $product,

                            'sf_cache_key'=> $product->getCacheKey()));?>

                <?php endforeach;?>

    </table>

        <?php else:?>

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
					<div class="hr clear" style="border-style: none none none;"><hr /></div>

            	<?php endfor;?>

		    </div><!--div-gallery-view-->

        <?php endif;?>

    

    <?php /*?><div class="pagenav">

        <div class="pagenavWrap">

                <?php echo pager_navigation($pager, url_for("@product_search")."?".join("&", $query_string_array))?>

        </div>

    </div><?php */?>

    <!--pagenav-->

    <?php endif?>



    <?php //include_component('product', 'featured')?>



</div><!--contentColumn-->



<div class="clear"></div>



<script type="text/javascript">

    $(document).ready( function() {

        $('#sortType').bind('change', function(){

            var query_string = "<?php echo join("&", $query_string_array)?>";

            window.location = '/<?php echo $sf_user->getCulture() ?>/productSearch'+ '?' + query_string + "&sortType=" + $(this).val()

        });

        //filter page table

        $('table.table-list-view tr:odd:not(.list-title, .featured)').addClass('even');

        $('table.table-list-view tr:even:not(.list-title, .featured)').addClass('odd');

<?php if (count($keywords)):?>

        var words = ['<?php echo join("','", $keywords)?>'];

        $('.table-list-view , .div-gallery-view').highlight(words);

<?php endif ?>

    });

</script>