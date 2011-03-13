<?php

class SetupController extends ApplicationController {
	function check_for_setup() {
		global $controller, $action;

		if(User::first() == null) {
			$controller = 'setup';
			if($action != 'create_first_user' && $action != 'setup_complete') {
				$action = 'first_user';
			}
		}
	}

	function first_user() {
		global $views, $helpers, $config;

		if(User::first() == null) {
			$views->template = 'setup/layout';
			$views->render('setup/first_user', array('username' => 'admin'));
		} else {
			$helpers->redirect($config['webroot'].'/');
		}
	}

	function create_first_user() {
		global $views, $helpers;

		if(User::first() == null) {
			// set the layout
			$views->template = 'setup/layout';

			// if passwords don't match
			$passwords_match = ($_REQUEST['password'] == $_REQUEST['password2']);
			if($passwords_match) {
				// try creating the user
				$user = new User(array(
					'username' => $_REQUEST['username'],
					'password' => $_REQUEST['password'],
				));
				$user->save();

				// validations
				$errors = false;
				if(!$user->is_valid()) {
					$errors = $user->errors->full_messages();
					$errors = $helpers->convert_errors_for_mustache($errors);
				}
			} else {
				$errors = array(array('message' => 'Password do not match'));
			}

			// yay, setup complete
			if(!$errors) {
				$views->render('setup/setup_complete');
			}
			// display errors
			else {
				$views->render('setup/first_user', array(
					'errors_exist' => true,
					'errors' => $errors,
					'username' => $_REQUEST['username']
				));
			}
		} else {
			$helpers->redirect($config['webroot'].'/');
		}
	}
}

$controllers['setup'] = new SetupController();

