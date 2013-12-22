<?php
define('SF_WEB_DIR',   realpath(dirname(__FILE__)));
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
sfContext::createInstance($configuration);


//updateProductExpire
//updateProductCurrency
//updateTopProducts
//clearShoppingCart
//recentProducts

$action_name = $argv[1];

$browser = new sfBrowser();
$browser->get("/cron/$action_name");

?>