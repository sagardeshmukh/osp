<div  id="mapOptionContent" style="" class="content-map">

  <form id="realEstateMapForm" action="<?php echo url_for('product/getAjax') ?>">



 <div class="categorywrap realestate">

        <div class="categoryselect">

            <div>FIND property on a map</div>

            <select class="textinput" name="searchKey">

                <option value="">Collapse</option>

                <?php $i=0; foreach($categories as $category): ?>

                <option value="search_id_realestate_<?php echo $category->getId() ?>"><?php echo $category->getName(); ?></option>

                <?php endforeach; ?>

            </select>

        </div>



<?php $i=0; foreach($categories as $category): ?>

   <div id="search_id_realestate_<?php echo $category->getId() ?>" class="filtergroup-wrapper filter">

    <div id="m-price" class="filtergroup">

        <h4><?php echo __('Price') ?></h4>

        <div class="filter-content">

            <input type="text" class="range" name="price_from">

            <span class="rangedivider"> - </span>

            <input type="text" class="range" name="price_to">

        </div>

    </div>

    <div id="m-bedrooms" class="filtergroup">

        <h4><?php echo __('Bedrooms') ?></h4>

        <div class="filter-content">

            <input type="text" class="range" name="bedrooms_from">

            <span class="rangedivider"> - </span>

            <input type="text" class="range" name="bedrooms_to">

        </div>

    </div>

    <div id="m-bedrooms" class="filtergroup">

        <h4><?php echo __('Property type') ?></h4>

        <div class="filter-content">

        	<?php 

				$pdo = Doctrine_Manager::getInstance()->connection();

				$propertyTypeResult = $pdo->execute("SELECT value, id FROM `attribute_values` WHERE attribute_id = 175");

				//$conn = sfDatabase::getConnection();

				$properties = $propertyTypeResult->fetchAll();

			?>

            <select class="textinput" name="propertyType">

                <option value=""><?php echo __('Property type') ?></option>

                <?php $i=0; foreach($properties as $property): ?>

                <option value="<?php echo $property['id'] ?>"><?php echo $property['value']; ?></option>

                <?php endforeach; ?>

            </select>

        </div>

    </div>

    <div id="m-date" class="filtergroup">

        <h4><?php echo __('Construction Date') ?></h4>

        <div class="filter-content">

        	<input type="text" class="range" name="date_from">

            <span class="rangedivider"> - </span>

            <input type="text" class="range" name="date_to">

        </div>

    </div>

    <?php // FLOOR ?>

    <div id="m-floor" class="filtergroup">

        <h4><?php echo __('Floor') ?></h4>

       <div class="filter-content">

            <?php 

				$pdo = Doctrine_Manager::getInstance()->connection();

				$floorResult = $pdo->execute("SELECT value, id FROM `attribute_values` WHERE attribute_id = 195");

				//$conn = sfDatabase::getConnection();

				$floors = $floorResult->fetchAll();

			?>

            <select class="textinput" name="floor">

                <option value=""><?php echo __('Floor') ?></option>

                <?php $i=0; foreach($floors as $floor): ?>

                <option value="<?php echo $floor['id'] ?>"><?php echo $floor['value']; ?></option>

                <?php endforeach; ?>

            </select>

        </div>

    </div>

	<?php // END FLOOR ?>

    

    <?php // Tenure ?>

    <div id="m-tenure" class="filtergroup">

        <h4><?php echo __('Tenure') ?></h4>

       <div class="filter-content">

            <?php 

				$pdo = Doctrine_Manager::getInstance()->connection();

				$tenureResult = $pdo->execute("SELECT value, id FROM `attribute_values` WHERE attribute_id = 176");

				//$conn = sfDatabase::getConnection();

				$tenures = $tenureResult->fetchAll();

			?>

            <select class="textinput" name="tenure">

                <option value=""><?php echo __('Tenure') ?></option>

                <?php $i=0; foreach($tenures as $tenure): ?>

                <option value="<?php echo $tenure['id'] ?>"><?php echo $tenure['value']; ?></option>

                <?php endforeach; ?>

            </select>

        </div>

    </div>

	<?php // END FLOOR ?>

    <div id="m-size" class="filtergroup">

        <h4><?php echo __('Area') ?> <span>(kvm)</span></h4>

        <div class="filter-content">

            <input type="text" class="range" name="area_from">

            <span class="rangedivider"> - </span>

            <input type="text" class="range" name="area_to">

        </div>

    </div>



    <?php /*?><div id="bedrooms" class="filtergroup">

        <h4><?php echo __('Bedrooms') ?> <span></span></h4>

        <div class="filter-content">

            <input type="text" class="range" name="bedrooms">

        </div>

    </div><?php */?>

   </div>

   <?php endforeach; ?>

    </div>



<div class="categorywrap rental">

        <div class="categoryselect">

            <div>FIND rental on a map</div>

            <select class="textinput" name="searchKey">

                <option value="">Collapse</option>

                <?php $i=0; foreach($rental_categories as $rcategory): ?>

                <option value="search_id_rental_<?php echo $rcategory->getId() ?>"><?php echo $rcategory->getName(); ?></option>

                <?php endforeach; ?>

            </select>

        </div>



<?php $i=0; foreach($rental_categories as $rcategory): ?>

   <div id="search_id_rental_<?php echo $rcategory->getId() ?>" class="filtergroup-wrapper filter">

    <div id="m-price" class="filtergroup">

        <h4><?php echo __('Price') ?></h4>

        <div class="filter-content">

            <input type="text" class="range" name="price_from">

            <span class="rangedivider"> - </span>

            <input type="text" class="range" name="price_to">

        </div>

    </div>



   </div>

   <?php endforeach; ?>

    </div>



    </form>

<br/>



    </div>