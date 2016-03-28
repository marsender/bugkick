<?php
$currDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$paramsDir = $currDir . 'params' . DIRECTORY_SEPARATOR;
$baseUrl = '/bugkick';

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

	'name'=>'BugKick',

	'theme'=>'bugkick_theme',

	'controllerMap' => require($currDir . 'controller-map.php'),


	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.components.payments.*',
		'application.components.plan_config.*',
		'application.components.view_more.*',
		'application.helpers.*',
		'application.components.storage.*',
		'application.modules.forum.components.*',
		'application.modules.forum.extensions.*',
	),

	'aliases' => array(
		'xupload' => 'ext.xupload',
	),

	'modules'=>array(
		'admin',
		'api',
		'github',
		// comment the following to disable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'forum'=>array(
			'userModelClassName'=>'User',
			'userRolePropertyName'=>'forum_role', // User model property that defines user role on forum
		),
	),


	// application components

	'components'=>array(

		'request'=>array(
			'class' => 'application.components.EHttpRequest',
			'enableCsrfValidation'=>true,
			'noCsrfValidationRoutes'=>array(
				'payment/stripe-web-hook',
				'api',
			)
		),

		'session' => array(
			'class' => 'CDbHttpSession',
			'connectionID' => 'db',
			'autoCreateSessionTable' => false,
			'sessionTableName'=>'bk_yii_session',
		),

		'user'=>array(
			//'class'=>'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'autoRenewCookie'=>true,
			'class' => 'BKWebUser',
		),

		'authManager' => array(
			'class' => 'BKPhpAuthManager',
			'defaultRoles' => array('guest'),
		),

		'image'=>array(
		  'class'=>'application.extensions.image.CImageComponent',
			// GD or ImageMagick
			'driver'=>'GD',
			// ImageMagick setup path
			//'params'=>array('directory'=>'/opt/local/bin'),
		),

		'logger' => array(
			'class' => 'Logger',
		),

		'notificator' => array(
			'class' => 'Notificator',
		),

		'mailer' => array(
			'class' => 'application.extensions.mailer.EMailer',
			//'pathViews' => 'application.views.email',
			//'pathLayouts' => 'application.views.email.layouts'
		),

		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path', // get or path
			'showScriptName' => false,
			'rules'=>require($currDir . 'routes.php'),
			/*
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			*/
		),

		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),

		// uncomment the following to use a MySQL database
		*/

		'db'=>require($currDir . 'db.php'),
		/**
		 * 	The database settings has been placed in db.php file.
		 *	So we can set this file as ignored in the .hgignore to
		 *	avoid the overwriting of developers local settings.
		 *
		 *	-f0t0n
		 *
		 'db'=>array(
			'connectionString' => 'mysql:host=bugs2.db.3312190.hostedresource.com;dbname=bugs2',
			'emulatePrepare' => true,
			'username' => 'bugs2',
			'password' => 'fwf3#sefsS',
			'charset' => 'utf8',
		),
		 */

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>require($currDir.'logroutes.php'),
		),

		'clientScript'=>array(
			'class'=>'application.components.ClientScript',
			'scriptMap'=>array(
				'jquery.js'=>false,
				'jquery.min.js'=>false,
				'jquery-ui.min.js'=>false,
				'jquery-ui.js'=>false,
			),
		),

		'syntaxhighlighter'=>array(
			'class'=>'ext.JMSyntaxHighlighter.JMSyntaxHighlighter',
			/*	Available themes:
							Default (the default if none provided)
							Django
							Eclipse
							Emacs
							FadeToGrey
							MDUltra
							Midnight
							RDark
			 */
			'theme'=>'Eclipse',
		),

		'widgetFactory' => array(
			'widgets' => array(
				'CLinkPager' => array(
					'nextPageLabel' => '<span class="pagination-right"></span>',
					'prevPageLabel' => '<span class="pagination-left"></span>',
				),
				'CJuiDialog' => array(
					'themeUrl' => $baseUrl . '/css/',
					'theme' => 'ui',
					'options'=>array(
						'resizable'=>false,
					)
				),
			),
		),

		'cache'=>array(
			'class'=>'system.caching.CApcCache',
		),

		 // Redis cache:
		'rcache'=>array(
			'class'=>'ext.redis.CRedisCache',
			//Cluster of servers:
			'servers'=>array(
				array(
					'host'=>'127.0.0.1',
					'port'=>6379
				),
//				other servers of the cluster:
//				array(
//					'host'=>'server2',
//					'port'=>6379,
//				),
			),
		),

		'CURL' =>array(
			'class'=>'application.extensions.curl.Curl',
			'options'=>array(
				'timeout'=>30,
				'setOptions'=>require($currDir . 'curl-options.php'),
			),
		),

		'minScript'=>array(
			'class'=>'ext.minScript.components.ExtMinScript',
			'allowDirs'=>array(
				'js',
				'css',
				'themes/bugkick_theme/css',
				'themes/bugkick_theme/js',
			),
		 ),

		/* File Storage */
		's3Storage'=>require($paramsDir . 's3-storage.php'),
		'localStorage' => array(
			'class' => 'application.components.storage.LocalStorage',
		),
		/* END of File Storage */

	),


	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => require($paramsDir . 'params.php'),

);
