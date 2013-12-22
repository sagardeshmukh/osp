<?php if($sf_request->getParameter('xType') == 'realestates'):?>
<ul class="cats">
  <li class="title icon icon6">
  	<a href="<?php echo url_for('@product_browse?xType=realestates') ?>"><?php echo __('Real Estate') ?></a> <em>(<?php echo Doctrine::getTable('Category')->find(myConstants::getCategoryId('realestates'))->getNbProducts()?>)</em>
  </li>
    <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('realestates'), true, 1, $sf_user->getCulture());?>
	  <?php foreach($childCategories as $i => $childCategory):?>
	  <li>
	    <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=realestates')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
	  </li>
    <?php endforeach?>
</ul>
<?php endif;?>
<?php if($sf_request->getParameter('xType') == 'cars'):?>
<ul class="cats">
  <li class="title icon icon7">
  	<a href="<?php echo url_for('@product_browse?xType=cars') ?>"><?php echo __('Cars') ?></a> <em>(<?php echo Doctrine::getTable('Category')->find(myConstants::getCategoryId('cars'))->getNbProducts()?>)</em>
  </li>
    <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('cars'), true, 1, $sf_user->getCulture());?>
	  <?php foreach($childCategories as $i => $childCategory):?>
	  <li>
	    <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=cars')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
	  </li>
    <?php endforeach?>
</ul>
<?php endif;?>
<?php if($sf_request->getParameter('xType') == 'products'):?>
<ul class="cats">
  <li class="title icon icon12">
  	<a href="<?php echo url_for('@product_browse?xType=products') ?>"><?php echo __('Products') ?></a> <em>(<?php echo Doctrine::getTable('Category')->find(myConstants::getCategoryId('products'))->getNbProducts()?>)</em>
  </li>
    <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('products'), true, 1, $sf_user->getCulture());?>
	  <?php foreach($childCategories as $i => $childCategory):?>
	  <li>
	    <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=products')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
	  </li>
    <?php endforeach?>
</ul>
<?php endif;?>

<?php if($sf_request->getParameter('xType') == 'jobs'):?>
<ul class="cats">
  <li class="title icon icon13">
  	<a href="<?php echo url_for('@product_browse?xType=jobs') ?>"><?php echo __('Jobs') ?></a> <em>(<?php echo Doctrine::getTable('Category')->find(myConstants::getCategoryId('jobs'))->getNbProducts()?>)</em>
  </li>
    <?php $childCategories = Doctrine::getTable('Category')->getChildren(myConstants::getCategoryId('jobs'), true, 1, $sf_user->getCulture());?>
	  <?php foreach($childCategories as $i => $childCategory):?>
	  <li>
	    <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId().'&xType=jobs')?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
	  </li>
    <?php endforeach?>
</ul>
<?php endif;?>

<?php /*if(in_array(sfConfig::get('category_id', 0), array(0,1175))):?>
<ul class="cats">
  <li class="title icon icon9">
  	<a href="/products">Бэлэг</a> <em>(<?php echo Doctrine::getTable('Category')->find(1175)->getNbProducts()?>)</em>
  </li>
    <?php $childCategories = Doctrine::getTable('Category')->getChildren(1175, true, 1);?>
	  <?php foreach($childCategories as $i => $childCategory):?>
	  <li>
	    <?php echo link_to($childCategory->getName(), '@product_browse?categoryId='.$childCategory->getId())?> <em>(<?php echo $childCategory->getNbProduct()?>)</em>
	  </li>
    <?php endforeach?>
</ul>
<?php endif; */?>
