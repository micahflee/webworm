<?php

class SetupController extends ApplicationController {
	public function create_first_user() {
		global $models, $views;

		// this is only allowed if there are no users
		if($models['user']->first() != false) {
			$views->error500();
		}

		// set the layout
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
}

$controllers['setup'] = new SetupController();

