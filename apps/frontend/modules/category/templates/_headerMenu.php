<li class="menu <?php echo $sf_params->get('xType')=='jobs'?'active':''?>">
	<a href="<?php echo url_for('@product_browse?xType=jobs') ?>" class="h"><strong><span class="icon eproduct"></span><?php echo __('Jobs') ?></strong></a>
</li>
<li class="menu <?php echo $sf_params->get('xType')=='cars'?'active':''?>">
	<a href="<?php echo url_for('@product_browse?xType=cars') ?>" class="h"><strong><span class="icon car"></span><?php echo __('Vehicle') ?></strong><em>More</em></a>
	  <div class="dropdown" style="width:200px;">
	    <div class="col lastCol">
      	  <h4><a href="<?php echo url_for('@product_browse?xType=cars') ?>"><?php echo __('All Vehicle') ?></a></h4>
	      <ul class="cat">
	      	  <?php $i = 0?>
	          <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('cars'), true, 1, $sf_user->getCulture());?>
	          <?php foreach($childCategories as $i => $childCategory):?>
	          <?php $i++?>
		        <li>
	              <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=cars')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
		        </li>
	          <?php endforeach?>
	      </ul>
	    </div>
	</div><!--dropdown-->
</li>


<li class="menu <?php echo $sf_params->get('xType') == 'realestates' ? 'active':''?>">
	<a href="<?php echo url_for('@product_browse?xType=realestates') ?>" class="h"><strong><span class="icon realestate"></span><?php echo __('Real estate') ?></strong><em>More</em></a>
	  <div class="dropdown" style="width:200px;">
	    <div class="col lastCol">
      	  <h4><a href="<?php echo url_for('@product_browse?xType=realestates') ?>"><?php echo __('All Real Estates') ?></a></h4>
	      <ul class="cat">
	      	  <?php $i = 0 ?>
	          <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('realestates'), true, 1, $sf_user->getCulture());?>
	          <?php foreach($childCategories as $i => $childCategory):?>
	          <?php $i++?>
		        <li>
	              <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=realestates')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
		        </li>
	          <?php endforeach?>
	      </ul>
	    </div>
	</div><!--dropdown-->
</li>
<li class="menu <?php echo $sf_params->get('xType')=='rental'?'active':''?>">
	<a href="<?php echo url_for('@product_browse?xType=rental') ?>" class="h"><strong><span class="icon rental"></span><?php echo __('Rental') ?></strong><em>More</em></a>
	  <div class="dropdown" style="width:220px;">
	    <div class="col lastCol">
      	  <h4><a href="<?php echo url_for('@product_browse?xType=rental') ?>"><?php echo __('All Rents') ?></a></h4>
	      <ul class="cat">
	      	  <?php $i = 0?>
	          <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('rental'), true, 1, $sf_user->getCulture());?>
	          <?php foreach($childCategories as $i => $childCategory):?>
	          <?php $i++?>
		        <li>
	              <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=rental')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
		        </li>
	          <?php endforeach?>
	      </ul>
	    </div>
	</div><!--dropdown-->
</li>
<li class="menu <?php echo $sf_params->get('xType')=='products'?'active':''?>">
	<a href="<?php echo url_for('@product_browse?xType=products') ?>" class="h"><strong><span class="icon product"></span><?php echo __('Products') ?></strong><em>More</em></a>
	  <div class="dropdown" style="width:220px;">
	    <div class="col lastCol">
      	  <h4><a href="<?php echo url_for('@product_browse?xType=products') ?>"><?php echo __('All Products') ?></a></h4>
	      <ul class="cat">
	      	  <?php $i = 0?>
	          <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('products'), true, 1, $sf_user->getCulture());?>
	          <?php foreach($childCategories as $i => $childCategory):?>
	          <?php $i++?>
		        <li>
	              <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=products')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
		        </li>
	          <?php endforeach?>
	      </ul>
	    </div>
	</div><!--dropdown-->
</li>
<li class="menu <?php echo $sf_params->get('xType') == 'service' ? 'active':''?>">
	<a href="<?php echo url_for('@product_browse?xType=service') ?>" class="h"><strong><span class="icon realestate"></span><?php echo __('Top Offers') ?></strong><em>More</em></a>
	  <div class="dropdown" style="width:200px;">
	    <div class="col lastCol">
      	  <h4><a href="<?php echo url_for('@product_browse?xType=service') ?>"><?php echo __('All Offers') ?></a></h4>
	      <ul class="cat">
	      	  <?php $i = 0?>
	          <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('service'), true, 1, $sf_user->getCulture());?>
	          <?php foreach($childCategories as $i => $childCategory):?>
	          <?php $i++?>
		        <li>
	              <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=service')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
		        </li>
	          <?php endforeach?>
	      </ul>
	    </div>
	</div><!--dropdown-->
</li>