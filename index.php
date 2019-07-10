<?php 
session_start();

define('DOMAIN', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']);
// var_dump(DOMAIN);

spl_autoload_register(function($class){
	require('./controller/'.$class.'.php');
});

foreach (glob('./model/*') as $model_name) {
	require($model_name);
}

require('./classes/Router.php');
require('./classes/View.php');

$router = new Router(); 



