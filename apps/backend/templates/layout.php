<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php //include_http_metas() ?>
    <?php //include_metas() ?>
    <?php //include_title() ?>
    
    <?php include_stylesheets() ?>
    <!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="/css/transdmin/ie6.css" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="/css/transdmin/ie7.css" /><![endif]-->
    <?php include_javascripts() ?>
    
    <link rel="shortcut icon" href="/favicon.ico" />
    <title>yozoa admin panel</title>
  </head>
  <body>
    <div id="wrapper">
      <h1><a href="/"><span>Yozoa admin panel</span></a></h1>
      <ul id="mainNav">
        <li><a class="<?php echo $sf_request->getParameter('module') == 'category' ? "active" : ""?>" href="<?php echo url_for('category/index')?>">Category</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'attribute' ? "active" : ""?>" href="<?php echo url_for('attribute/index')?>">Attribute</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'product' ? "active" : ""?>" href="<?php echo url_for('product/index')?>">Product</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'help_category' ? "active" : ""?>" href="<?php echo url_for('help_category/index')?>">Help</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'guestbook' ? "active" : ""?>" href="<?php echo url_for('guestbook/index?id=0')?>">Guestbook</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'banner' ? "active" : ""?>" href="<?php echo url_for('banner/index')?>">Banner</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'currency' ? "active" : ""?>" href="<?php echo url_for('currency/index')?>">Currency</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'xarea' ? "active" : ""?>" href="<?php echo url_for('xarea/index')?>">Location</a></li>
        <li><a class="<?php echo in_array($sf_request->getParameter('module'), array('translation', 'language')) ? "active" : ""?>" href="<?php echo url_for('translation/index')?>">Translation/Language</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'priceFormat' ? "active" : ""?>" href="<?php echo url_for('priceFormat/index')?>">Price</a></li>
        <li class="logout"><a href="<?php echo url_for('user/logout')?>">LOGOUT</a></li>
      </ul>
      <?php if ($sf_user->hasFlash('success')): ?>
      <div class="success"><?php echo $sf_user->getFlash('success') ?></div>
      <?php endif?>
      <div id="containerHolder">
        <div id="container">
          <div id="sidebar">
            <ul class="sideNav">
              <?php if ($sf_request->getParameter('module') == 'category'):?>
                <li><a href="<?php echo url_for('category/index')?>" class="">Category List</a></li>
                <li><a href="<?php echo url_for('category/new')?>" class="">New Category</a></li>
                <li>
                <h3>Search</h3>
                <form style="margin-left: 10px;" action="<?php echo url_for('category/search') ?>" method="get">
                <input type="text" style="width: 150px;" name="keyword" value="<?php echo $sf_params->get('keyword'); ?>" />
                <input type="submit" value="search"/>
                </form>
                </li>
              <?php elseif($sf_request->getParameter('module') == 'attribute'):?>
                <li><a href="<?php echo url_for('attribute/index')?>" class="">Attribute List</a></li>
                <li><a href="<?php echo url_for('attribute/new')?>" class="">New Attribute</a></li>
                <li><a href="<?php echo url_for('attribute/translationList')?>" class="">Translation attribute list</a></li>
                <li>
                <h3>Search</h3>
                <form style="margin-left: 10px;" action="<?php echo url_for('attribute/search') ?>" method="get">
                <input type="text" style="width: 150px;" name="keyword" value="<?php echo $sf_params->get('keyword'); ?>" />
                <input type="submit" value="search"/>
                </form>
                </li>
              <?php elseif($sf_request->getParameter('module') == 'help_category' || $sf_request->getParameter('module') == 'help_topic' ):?>
                <li><a href="<?php echo url_for('help_category/index')?>" class="">Help Category List</a></li>
                <li><a href="<?php echo url_for('help_category/new')?>" class="">New help category</a></li>
                <li><a href="<?php echo url_for('help_topic/new')?>" class="">New help add</a></li>
                <li><a href="<?php echo url_for('help_topic/index')?>" class="">Help list</a></li>
              <?php elseif($sf_request->getParameter('module') == 'guestbook'):?>
                <li><a class="<?php echo $sf_request->getParameter('module') == 'guestbook' ? "active" : ""?>" href="<?php echo url_for('guestbook/index?id=1')?>">Published</a></li>
                <li><a href="<?php echo url_for('guestbook/index?id=0')?>" class="">New</a></li>
              <?php elseif($sf_request->getParameter('module') == 'product'):?>
                <li><a href="<?php echo url_for('product/index?status=all')?>" class="">All</a></li>
                <li><a href="<?php echo url_for('product/index?status=pending')?>" class="">Pending</a></li>
                <li><a href="<?php echo url_for('product/index?status=denied')?>" class="">Denied</a></li>
              <?php elseif($sf_request->getParameter('module') == 'news'):?>
                <li><a href="<?php echo url_for('news/index')?>" class="">All</a></li>
                <li><a href="<?php echo url_for('news/new')?>" class="">New</a></li>
              <?php elseif($sf_request->getParameter('module') == 'banner'):?>
                <li><a href="<?php echo url_for('banner/index')?>" class="">All</a></li>
                <li><a href="<?php echo url_for('banner/new')?>" class="">New</a></li>
              <?php elseif($sf_request->getParameter('module') == 'currency'):?>
                <li><a href="<?php echo url_for('currency/addEdit')?>" class="">Add Currency</a></li>
                <li><a href="<?php echo url_for('currency/index')?>" class="">Index</a></li>
              <?php elseif($sf_request->getParameter('module') == 'xarea'):?>
                <!--<li><a href="<?php echo url_for('xarea/new')?>" class="">New</a></li>-->
                <li><a href="<?php echo url_for('xarea/index')?>" class="">List</a></li>
              <?php elseif($sf_request->getParameter('module') == 'translation' || $sf_request->getParameter('module') == 'language'):?>
                <li><a href="<?php echo url_for('translation/index')?>" class="">Translation list</a></li>
                <li><a href="<?php echo url_for('translation/createElement')?>" class="">Create Element</a></li>
                <li><a href="<?php echo url_for('translation/createTranslation')?>" class="">Create Translation file</a></li>
                <li><a href="<?php echo url_for('language/index')?>" class="">Language list</a></li>
                <li><a href="<?php echo url_for('language/new')?>" class="">Add New Language</a></li>
              <?php elseif ($sf_request->getParameter('module') == 'priceFormat'):?>
                <li><a href="<?php echo url_for('priceFormat/index')?>" class="">Price List</a></li>
                <li><a href="<?php echo url_for('priceFormat/new')?>" class="">New Price</a></li>
              <?php endif?>
            </ul>
          </div>
          <div id="main">
            <?php echo $sf_content ?>
          </div>
          <div class="clear"></div>
        </div>
      </div>
      <p id="footer">www.yozoa.mn <a href="http://singleton.mn" target="_blank">Singleton LLC</a></p>
    </div>
  </body>
</html>