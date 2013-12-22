<div id="header">			

  <div id="logo"><a href="<?php echo url_for("@homepage") ?>"></a>

    <div style="padding-left: 0px; color: #ccc">

	  	Beta version...

    </div>

  </div>

  <ul id="top-menu">

    <?php if (!$sf_user->isLogged()): ?>

      <li><a href="<?php echo url_for("@user_login") ?>"><?php echo __('Login') ?></a></li>

      <li><a href="<?php echo url_for("user/new") ?>"><?php echo __('Join') ?></a></li>

    <?php else: ?>

        <li>

          <a href="<?php echo url_for("user/profile") ?>"><b><?php echo $sf_user->getName() ?></b></a>

          <div class="userDropDown">

            <a href="<?php echo url_for('user/profile') ?>"><?php echo __('Info') ?></a>

          </div>

        </li>

        <li><a href="<?php echo url_for('manageProduct/myProduct') ?>"><b><?php echo __('My Products') ?>(<span id="nbProductInBasket"><?php echo Doctrine::getTable('Product')->countUserProducts($sf_user->getId()) ?></span>)</b></a></li>

    <?php endif ?>

    <?php if ($sf_user->isLogged()): ?>

          <li><a href="<?php echo url_for('user/logout') ?>"><b><?php echo __('Logout') ?></b></a></li>

    <?php endif ?>

          <li><a class="<?php echo $sf_request->getParameter('module') == 'help' ? "active" : "" ?>" href="<?php echo url_for('help/index') ?>"><?php echo __('Help') ?></a></li>

          <li class="post-ad"><a href="<?php echo url_for("manageProduct/step1") ?>"><?php echo __('Add product') ?></a><img src="/images/post-ad-free.png" /></li>

        </ul><?php
			 include_component('language', 'language') ?>

        <div id="main-menu">

          <ul>

      <?php include_component('category', 'headerMenu') ?>

        </ul>

      </div>

    </div><!--header-->

	<?php //echo "[" . $product = Doctrine::getTable('Product')->find($sf_request->getParameter('product_id'))->getCategoryType() . "]" ?>

	<?php //echo "[". $sf_request->getParameter('categoryId') ."][". $sf_request->getParameter('category_id') ."][" . $sf_request->getParameter('xType') . "]"; ?>

    <?php 

		// LNA 22.08.2011
		$xType = '';

		if ($sf_request->getParameter('xType') != '')

		{

			$xType = $sf_request->getParameter('xType');

		}

		

		if ($sf_request->getParameter('product_id') != '' && $xType == ''){

			$xType = Doctrine::getTable('Product')->find($sf_request->getParameter('product_id'))->getCategoryType();	

		}



		if ($sf_request->getParameter('id') != '' && $xType == ''){

			$xType = Doctrine::getTable('Product')->find($sf_request->getParameter('id'))->getCategoryType();	

		}

		if ($sf_request->getParameter('categoryId') != '' && $xType == ''){

			$xType = $sf_request->getParameter('categoryId');	

		}

		$xType = isset($xType) ? $xType: "products";

	?>

    <?php 
		$current_category = '';
		switch ($xType){

			case "jobs":

				$current_category = 1217;

			break;	

			case "cars":

				$current_category = 1269;

			break;	

			case "realestates":

				$current_category = 38;

			break;	

			case "rental":

				$current_category = 1370;

			break;	

			case "products":

				$current_category = 1;

			break;

		}

	?>

    <div id="search-box">

      <form name="search_form" id="search_form" action="<?php echo url_for("@product_search") ?>">Search

        <input type="text" value="<?php echo $sf_request->getParameter('keyword') ?>" id="keyword" name="keyword" class="key" style="width:50%" />

        <input type="hidden" name="categoryId" id="sCategoryId" value="0" />

        <input type="hidden" name="type" id="sType" value="-1" />

        <select class="key" id="searchTypeId"  style="width:200px">

          <?php /*?><option value="0" <?php if ($sf_request->getParameter('categoryId') == 0) echo 'selected="selected"' ?>><?php echo __('All categories') ?></option><?php */?>

          <option value="1215" <?php if ($current_category == 1215) echo 'selected="selected"' ?>><?php echo __('Jobs') ?></option>

          <option value="1269" <?php if ($current_category == 1269) echo 'selected="selected"' ?>><?php echo __('Vehicle') ?></option>

          <option value="38" <?php if ($current_category == 38) echo 'selected="selected"' ?>><?php echo __('Real estate') ?></option>

          <option value="1370" <?php if ($current_category == 1370) echo 'selected="selected"' ?>><?php echo __('Rental') ?></option>

          <option value="1" <?php if ($current_category == 1) echo 'selected="selected"' ?>><?php echo __('Products') ?></option>

        </select>

        <input type="submit" class="submit" value=" Search " />

    <?php $xType = $sf_request->getParameter('xType') ? $sf_request->getParameter('xType') : 'products'; ?>

                    <a href="<?php echo url_for('@advanced_search?xType='.$xType) ?>" style="display:none;">Advanced search</a>

     </form>

  <script type="text/javascript">

    $(document).ready( function() {

      function changeSearchType(){

        if ($("#searchTypeId").val() == "shop"){

          $("#sCategoryId").val("0");

          $("#sType").val("0");

        } else {

          $("#sCategoryId").val($("#searchTypeId").val());

          $("#sType").val("-1");

        }

      }

      $("#searchTypeId").bind('change', function(){

        changeSearchType();

      });

      changeSearchType();

    });

  </script>

</div>