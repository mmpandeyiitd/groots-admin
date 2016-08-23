<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$constants=dirname(__FILE__).'/protected/config/constants.php';
$utility=dirname(__FILE__).'/protected/utility/Utility.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once($constants);
require_once($utility);

Yii::createWebApplication($config)->run();
