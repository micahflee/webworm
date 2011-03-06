<?php

class DashboardController extends ApplicationController {
	function index() {
		echo('yay!');
	}
}

$controllers['dashboard'] = new DashboardController();

