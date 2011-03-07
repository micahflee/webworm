<?php

class SetupController extends ApplicationController {
	function __construct() {
		$this->add_before_filter(function(){
			// only allow if not set up
			return (User::first() == null);
		});
	}

	function check_for_setup() {
		global $controller, $action;

		$controller = 'setup';
		if($action != 'create_first_user' && $action != 'setup_complete') {
			$action = 'first_user';
		}
	}

	function first_user() {
		global $views;
		$views->template = 'setup/layout';
		$views->render('setup/first_user', array('username' => 'admin'));
	}

	function create_first_user() {
		// TODO: finish making this work with activerecord

		global $views;

		// set the layout
		$views->template = 'setup/layout';

		// try creating the user
		$user = new User(array(
			'username' => $_REQUEST['username'],
			'password' => $_REQUEST['password'],
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

