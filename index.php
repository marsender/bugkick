<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$init=dirname(__FILE__).'/protected/config/init.php';

require_once($init);
require_once($yii);
Yii::createWebApplication($config)->run();