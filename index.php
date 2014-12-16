<?php

$yii = dirname(__FILE__).'/yii-1.1.15/yii.php';
$config = dirname(__FILE__).'/protected/config/front.php';
  
// Remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
// On dev display all errors
if(YII_DEBUG) {
	error_reporting(-1);
	ini_set('display_errors', true);
}  
require_once($yii);
//Yii::createWebApplication($config)->runEnd('front');
// create the application instance but don't run it yet
$app = Yii::createWebApplication($config);
// see if a conference id is present otherwise we want the default conference (active, most recent)
//if(isset($_GET['c']))
//{
//    $app->params->conferenceID = $_GET['c'];
//} else {
//    $app->params->conferenceID = Conference::activeConference();
//}
/* please, uncomment the following if you are using ZF library */

Yii::import('extensions.EZendAutoloader', true);
//
EZendAutoloader::$prefixes = array('Zend','Skoch','Polycast');
EZendAutoloader::$basePath = Yii::getPathOfAlias('libs') . DIRECTORY_SEPARATOR;
Yii::registerAutoloader(array("EZendAutoloader", "loadClass"), true);
//
Yii::setPathOfAlias('Imagine',Yii::getPathOfAlias('libs.Imagine'));
Yii::import('extensions.EImagineAutoloader', true);
Yii::registerAutoloader(array("EImagineAutoloader", "loadClass"), true);
//
Yii::setPathOfAlias('paypal',Yii::getPathOfAlias('vendors.paypal'));
Yii::import('vendors.composer.ComposerAutoloaderInitPaypal', true);
Yii::registerAutoloader(array("ComposerAutoloaderInitPaypal", "getLoader"), true);


Yii::setPathOfAlias('phpexcel',Yii::getPathOfAlias('vendors.Classes'));
Yii::import('vendors.Classes.PHPExcel', true);

Yii::setPathOfAlias('phpword',Yii::getPathOfAlias('vendors.Classes'));
Yii::import('vendors.Classes.PHPWord', true);

Yii::setPathOfAlias('phppowerpoint',Yii::getPathOfAlias('vendors.Classes'));
Yii::import('vendors.Classes.PHPPowerPoint', true);

//  here we go!
$app->runEnd('front');