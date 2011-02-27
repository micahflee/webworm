<?php

class SetupController extends ApplicationController {
	public function __construct() {
		$this->add_before_filter('only_allow_if_not_set_up');
	}

	public function only_allow_if_not_set_up() {
		global $models;
		return ($models['user']->first() == false);
	}

	public static function check_for_setup() {
		global $models, $controller, $action;

		if($models['user']->first() == false) {
			$controller = 'setup';
			if($action != 'create_first_user' && $action != 'setup_complete') {
				$action = 'first_user';
			}
		}
	}

	public function first_user() {
		global $views;
		$views->template = 'setup/layout';
		$views->render('setup/first_user', array('username' => 'admin'));
	}

	public function create_first_user() {
		global $models, $views, $helpers;

		// set the layout
		$views->template = 'setup/layout';

		// validation
		$errors = array();
		if($_REQUEST['password'] != $_REQUEST['password2']) 
			array_push($errors, array('message' => 'Passwords do not match'));
		if(empty($_REQUEST['username'])) 
			array_push($errors, array('message' => 'Must enter a username'));
		if(empty($_REQUEST['password'])) 
			array_push($errors, array('message' => 'Must enter a password'));

		// try adding user
		if(empty($errors)) {
			$user = $models['user']->get();
			$user->username = $_REQUEST['username'];
			$user->password = $models['user']->password($_REQUEST['password']);
			$user->date_created = $helpers->date();
			if(!$models['user']->save($user)) {
				if(empty($errors))
					array_push($errors, array('message' => 'There were errors'));
			}
		}

		// yay, setup complete
		if(empty($errors)) {
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

