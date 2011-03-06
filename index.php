<?php
require('config.php');
require('lib/boot.php');

// what route is the user asking for?
$method = strtolower($_SERVER['REQUEST_METHOD']);
$controller = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'reader';
$action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';

// override the route if needed
$session->check_for_login();
$controllers['setup']->check_for_setup();

// display debug info if debug mode is enabled
//$helpers->display_debug_info();

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

