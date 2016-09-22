<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=cb_dev_groots',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ),


        'secondaryDb'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=groots_orders',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'class'=>'CDbConnection'
        ),

        'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
    'modules'=>array(
        'user'=>array(
            'hash' => 'md5', # encrypting method (php hash function)
            'sendActivationMail' => true, # send activation email
            'loginNotActiv' => false, # allow access for non-activated users
            'activeAfterRegister' => false, # activate user on registration (only sendActivationMail = false)
            'autoLogin' => true, # automatically login from registration
            'registrationUrl' => array('/user/registration'), # registration path
            'recoveryUrl' => array('/user/recovery'), # recovery password path
            'loginUrl' => array('/user/login'), # login form path
            'returnUrl' => array('/user/profile'), # page after login
            'returnLogoutUrl' => array('/user/login'), # page after logout
        ),
    ),
    'commandMap'=>array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
            'migrationPath'=>'application.modules.user.migrations',
            'migrationTable'=>'tbl_migration',
            'connectionID'=>'db',
            'templateFile'=>'application.migrations.template',
        ),
    ),
);