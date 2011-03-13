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
		global $session;
		$user = User::find($session->user_id());
		foreach($user->feeds as $feed) {
			echo("<p>".$feed->feed_url."</p>");
		}
		//echo(json_encode($user->feeds));
	}

	function load_more_posts() {
	}
}

$controllers['reader'] = new ReaderController();

