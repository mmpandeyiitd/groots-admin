<?php  require_once( dirname(__FILE__) . '/../components/Log.php');


return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Brand Admin Panel',
 	'theme' =>'abound',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'kuldeep',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
            
            'Smtpmail'=>array(
            'class'=>'application.extensions.smtpmail.PHPMailer',
            'Host'=>"mail.yourdomain.com",
            'Username'=>'test@yourdomain.com',
            'Password'=>'test',
            'Mailer'=>'smtp',
            'Port'=>26,
            'SMTPAuth'=>true, 
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                   
		),
             'image'=>array(
                    'class'=>'application.extensions.image.CImageComponent',
                    'driver'=>'GD',
                   'params'=>array('directory'=>'/opt/local/bin'),
                    ),
                       
           
		'defaultPageSize' => 10,
	
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
                /*
i		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dev_groots',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),


        'secondaryDb'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=dev_goots_order',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'class'=>'CDbConnection'
        ),  

        'db_log'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=dev_goots_log',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'class'=>'CDbConnection'
        ),



		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
            'defaultPageSize' => 10,
	),
);



