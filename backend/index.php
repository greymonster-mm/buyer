<?php
error_reporting(0);
require './vendor/autoload.php';
define('APPLICATION_PATH', dirname(__FILE__));

$application = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();

?>
