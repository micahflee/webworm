<?php

class SetupController extends ApplicationController {
	function __construct() {
		$this->add_before_filter('only_allow_if_not_set_up');
	}

	function only_allow_if_not_set_up() {
		global $models;
		return ($models['user']->first() == false);
	}

	function check_for_setup() {
		global $models, $controller, $action;

		if($models['user']->first() == false) {
			$controller = 'setup';
			if($action != 'create_first_user' && $action != 'setup_complete') {
				$action = 'first_user';
			}
		}
	}

	function first_user() {
		global $views;
		$views->template = 'setup/layout';
		$views->render('setup/first_user', array('username' => 'admin'));
	}

	function create_first_user() {
		global $views, $models;

		// set the layout
		$views->template = 'setup/layout';

		// try creating the user
		$errors = $models['user']->create(array(
			'username' => $_REQUEST['username'],
			'password' => $_REQUEST['password'],
			'password2' => $_REQUEST['password2']
		));
		
		// yay, setup complete
		if($errors === true) {
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
	}
}

$controllers['setup'] = new SetupController();

