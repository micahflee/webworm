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
	
	function add_feed() {
		// make sure a feed_url has been passed
		if(!isset($_REQUEST['feed_url'])) {
			echo(json_encode(array('error' => 'Did not pass a feed URL')));
			return;
		}
		$feed_url = $_REQUEST['feed_url'];

		// see if the feed is already in the database
		$feed = Feed::first(array('conditions' => array('url' => $feed_url)));

		// it's not, see if it's a valid feed
		if(!$feed) {
			// download the feed_url
			$output = file_get_contents($feed_url);

			/* TODO:
			 * see if simplepie can parse it
			 * if yes, create a feed from it, set it to $feed
			 * if no, check to see if a feed url is defined in the html
			 * if yes, repeat process with new feed url
			 * if no, return error
			 */
		}

		// TODO: we should have a valid feed in the database now, so add a user_feed for the current user and return success
		
		global $session;
		$user = User::find($session->user_id());
	}
	
	function load_feeds() {
		global $session;
		$user = User::find($session->user_id());
		$json_feeds = array();
		foreach($user->feeds as $feed) {
			$json_feeds[] = array(
				'name' => $feed->name,
				'url' => $feed->url
			);
		}
		echo(json_encode($json_feeds));
	}

	function load_more_posts() {
	}
}

$controllers['reader'] = new ReaderController();

