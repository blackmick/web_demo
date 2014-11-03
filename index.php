<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
$g_App = Yii::createWebApplication($config);
$g_App->setControllerPath($g_App->getBasePath().DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'guest');
$g_App->setViewPath($g_App->getBasePath().DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'guest');
$g_App->run();
