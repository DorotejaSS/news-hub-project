<?php 
session_start();

//								http 				www.news-hub.com 
define('DOMAIN', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']);

spl_autoload_register(function($class){
	require('./controller/'.$class.'.php');
});

require('./model/Channel.php');

foreach (glob('./classes/*') as $class_name) {
	require($class_name);
}

$router = new Router(); 



