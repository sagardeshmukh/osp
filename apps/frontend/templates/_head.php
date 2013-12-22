<?php $title = sfContext::getInstance()->getResponse()->getTitle();?>
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php echo content_tag('title', "OneStepProperty - " . $title)."\n"; ?>
<?php /*?><link rel="shortcut icon" href="/images/favicon.ico" /><?php */?>
<?php include_stylesheets() ?>
<link rel="stylesheet" type="text/css" href="/css/print.css" media="print">
<?php include_javascripts() ?>
