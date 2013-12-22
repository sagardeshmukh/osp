<?php
//define('SF_WEB_DIR',   realpath(dirname(__FILE__)));

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);

sfContext::createInstance($configuration)->dispatch();

?>