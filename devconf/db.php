<?php
/*
'db'=>array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
),
* Mysql config
'db'=>array(
	'connectionString' => 'mysql:host=bugs2.db.3312190.hostedresource.com;dbname=bugs2',
	'emulatePrepare' => true,
	'username' => 'bugs2',
	'password' => 'fwf3#sefsS',
	'charset' => 'utf8',
),
*/
$isProfilingEnabled=defined('YII_PROFILE') && YII_PROFILE > 0;
return array(
	'connectionString' => 'mysql:host=localhost;dbname=bugkick',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
  'tablePrefix' => 'bk_',
	'enableProfiling'=>$isProfilingEnabled,
	'enableParamLogging'=>$isProfilingEnabled,
);
