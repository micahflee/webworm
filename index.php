<?php
require('config.php');
require('lib/boot.php');

// what route is the user asking for?
$method = strtolower($_SERVER['REQUEST_METHOD']);
$controller = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'dashboard';
$action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';

// override the route if needed
$session->check_for_login();
$controllers['setup']->check_for_setup();

if($config['debug']) {
	echo("<pre style=\"text-align:center; background-color:black; color:#999999; padding:5px; margin:0;\">c: $controller - a: $action - ".($session->logged_in() ? "logged in" : "not logged in")."</pre>");
}

// route the request
$valid = true;
if(isset($controllers[$controller])) {
	if(method_exists($controllers[$controller], $action)) {
		if($controllers[$controller]->run_before_filters()) {
			$controllers[$controller]->$action();
		} else {
			$views->error500();
		}
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

