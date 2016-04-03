<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// trace application (false for production mode)
defined('YII_TRACE') or define('YII_TRACE',false);
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_DEBUG_LEVEL') or define('YII_DEBUG_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
