<?php
//define('SF_WEB_DIR',   realpath(dirname(__FILE__)));
//echo "testing"; exit;
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);

//echo "Hello world"; exit;
sfContext::createInstance($configuration)->dispatch();
//echo "Hello"; exit;
?>
