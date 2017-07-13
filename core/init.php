
<?php

session_start();


$GLOBALS['config']=array(
	'mysql'=>[
		'host'=>'127.0.0.1',
		'username'=>'root',
		'password'=>'myke',
		'db'=> 'PDO'
	],
	'remember'=>[
		'cookie_name'=>'hash',
		'cookie_expirery'=>604800
	],
	'sessions'=>[
		'session_name'=>'user',
		'token_name'=>'token'
	]
);


spl_autoload_register(function($class){
	require_once('classes/'.$class.'.php');
});

require_once('functions/sanitize.php');