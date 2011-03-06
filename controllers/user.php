<?php

class UserController extends ApplicationController {
	function __construct() {
		$this->add_before_filter('set_template');
	}

	function login_screen() {
		global $models, $views, $session, $helpers, $config;

		if($session->logged_in()) $helpers->redirect($config['webroot'].'/');

		$views->template = 'public/layout';
		$views->render('public/login_screen', array('title' => 'Welcome to Webworm'));
	}
	
	function login() {
		global $models, $views, $session, $helpers, $config;
		
		if($session->logged_in()) $helpers->redirect($config['webroot'].'/');

		// valid username and password?
		$error = false;
		if(empty($_REQUEST['username']) || empty($_REQUEST['password'])) $error = true;
		$user = $models['user']->first(array('username' => $_REQUEST['username']));
		if($user) {
			if(!$user->verify_password($_REQUEST['password'])) {
				$error = true;
			}
		} else {
			$error = true;
		}

		// logged in?
		if($error) {
			$views->template = 'public/layout';
			$views->render('public/login_screen', array(
				'title' => 'Welcome to Webworm',
				'error' => true
			));
		} else {
			$session->login($user);
			$helpers->redirect($config['webroot']."/");
		}
	}

	function logout() {
		global $session, $helpers, $config;
		$session->logout();
		$helpers->redirect($config['webroot']."/");
	}
}

$controllers['user'] = new UserController();

