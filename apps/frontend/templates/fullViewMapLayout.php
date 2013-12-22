<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta name="robots" content="index, follow"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="language" content="mn" />
    <?php include_partial('global/head') ?>
	<!--<link rel="stylesheet" type="text/css" media="screen" href="/css/map.css" />-->
	<link rel="stylesheet" type="text/css" media="screen" href="/css/autocomplete.css" />
	<script src="/js/jquery-1.4.2.min.js" type="text/javascript"></script>
	<!--<script src="/js/jquery.autocomplete-min.js" type="text/javascript"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script src="/js/markermanager_packed.js" type="text/javascript"></script>
	<script type="text/javascript" src="/js/markerclusterer.js"></script>
	<script type="text/javascript" src="/js/YozoaMap.js"></script>-->
  </head>
  <body style="overflow:hidden; height:100%; width:100%;">
    <div id="wrapper" style="width:100%">
      <?php //include_partial('global/header') ?>
      <?php include_partial('global/messages') ?>
      <?php echo $sf_content ?>
      <?php //include_partial('global/footer') ?>
    </div>
  </body>
</html>