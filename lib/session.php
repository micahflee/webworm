<?php

class Session {
	function __construct() {
		session_start();
	}

	function login($user) {
		$_SESSION['user'] = array();
		$_SESSION['user']['id'] = $user->id;
		$_SESSION['user']['username'] = $user->username;
	}

	function logout() {
		session_unset();
	}

	function logged_in() {
		return isset($_SESSION['user']);
	}

	function check_for_login() {
		global $controller, $action;
		
		if($controller != 'setup' && !$this->logged_in()) {
			$controller = 'user';
			$action = 'login_screen';
		}
	}
}

$session = new Session;
