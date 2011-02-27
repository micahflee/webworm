<?php

class DashboardController {
	public function index() {
		global $User, $views;

		// do we need to create a new user?
		if($User->first() == false) {
			$views->template = 'setup/layout';
			echo($views->render('setup/first_user'));
			exit();
		}
	}
}

$controllers['dashboard'] = new DashboardController();

