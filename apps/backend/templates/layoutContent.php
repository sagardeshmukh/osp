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
      <h1><a href="/"><span>yozoa admin panel</span></a></h1>
      <ul id="mainNav">
        <li><a class="<?php echo $sf_request->getParameter('module') == 'category' ? "active" : ""?>" href="<?php echo url_for('category/index')?>">Category</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'attribute' ? "active" : ""?>" href="<?php echo url_for('attribute/index')?>">Attribute</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'product' ? "active" : ""?>" href="<?php echo url_for('product/index')?>">Product</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'help' ? "active" : ""?>" href="<?php echo url_for('help/index')?>">Help</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'guestbook' ? "active" : ""?>" href="<?php echo url_for('guestbook/index')?>">Guestbook</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'news' ? "active" : ""?>" href="<?php echo url_for('news/index')?>">News</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'banner' ? "active" : ""?>" href="<?php echo url_for('banner/index')?>">Banner</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'store' ? "active" : ""?>" href="<?php echo url_for('store/index?is_paid=1')?>">Store</a></li>
        <li><a class="<?php echo $sf_request->getParameter('module') == 'payment' ? "active" : ""?>" href="<?php echo url_for('payment/index?status=processing')?>">Payment</a></li>
        <li class="logout"><a href="<?php echo url_for('user/logout')?>">LOGOUT</a></li>
      </ul>
      <?php if ($sf_user->hasFlash('success')): ?>
      <div class="success"><?php echo $sf_user->getFlash('success') ?></div>
      <?php endif?>
      <div id="containerHolder" style="background:url('/images/transdmin/content.gif') repeat-x scroll left top #FFFFFF;border:1px solid #EEEEEE;">
        <?php echo $sf_content ?>
        <div class="clear"></div>
      </div>
      <p id="footer">www.yozoa.mn <a href="http://singleton.mn" target="_blank">Singleton LLC</a></p>
    </div>
  </body>
</html>