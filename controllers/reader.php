<?php

class ReaderController extends ApplicationController {
	function __construct() {
		$this->add_before_filter(function(){
			// allow only if logged in
			global $session;
			return $session->logged_in();
		});
	}

	function index() {
		global $views;
		echo($views->render_partial('reader/layout'));
		exit();
	}

	// ajax actions
	
	function load_feeds() {
		global $models, $session;
		$user = $models['user']->get($session->user_id());
		$feeds = $user->feeds();
		echo(json_encode($feeds));
	}

	function load_more_posts() {
	}
}

$controllers['reader'] = new ReaderController();

