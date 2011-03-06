<?php

class DashboardController extends ApplicationController {
	function index() {
		echo('yay! <a href="/?c=user&a=logout">log out</a>');
	}
}

$controllers['dashboard'] = new DashboardController();

