<?php

class UserController extends ApplicationController {
	public function login_screen() {
		global $models, $views;

		$views->template = 'public/layout';
		$views->render('public/login_screen', array('title' => 'Welcome to Webworm'));
	}
	
	public function create_first_user() {
		global $models, $views;
		$views->template = 'setup/layout';

		// check that passwords match
		$errors = array();
		if($_REQUEST['password'] != $_REQUEST['password2']) {
			array_push($errors, 'Passwords do not match');
		}

		// try adding user
		if(!empty($errors)) {
			$user = $models['user']->get();
			$user->username = $_REQUEST['username'];
			$user->password = $_REQUEST['password'];
			if(!$models['user']->save($user)) {
				if(empty($_REQUEST['username'])) array_push($errors, 'Must enter a username');
				if(empty($_REQUEST['password'])) array_push($errors, 'Must enter a password');
			}
		}

		// yay, setup complete
		if(empty($errors)) {
			$views->render('setup/setup_complete');
		}
		// display errors
		else {
			$views->render('setup/first_user', array('errors' => $errors));
		}
	}

	public function login() {
	}

}

$controllers['user'] = new UserController();

