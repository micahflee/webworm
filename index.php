<?php
require('config.php');
require('lib/boot.php');

// route the request
$method = strtolower($_SERVER['REQUEST_METHOD']);
$controller = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'user';
$action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'login_screen';

// valid controller?
$valid = true;
if(isset($controllers[$controller])) {
	// valid action?
	if(method_exists($controllers[$controller], $action)) {
		$controllers[$controller]->$action();
	} else {
		$valid = false;
	}
} else {
	$valid = false;
}
if(!$valid) {
	echo($views->render_partial("error/route_error"));
	exit();
}

