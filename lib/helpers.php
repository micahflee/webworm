<?php

class Helpers {
	function redirect($url) {
		header("Location: $url");
		exit();
	}

	function display_debug_info() {
		global $config, $method, $controller, $action, $session;
		if($config['debug']) {
			echo("<pre style=\"text-align:center; background-color:black; color:#999999; padding:5px; margin:0;\"><span style=\"color:#666666\">[DEBUG INFO]</span>  controller: <span style=\"color:#ffffff\">$controller</span> - action: <span style=\"color:#ffffff\">$action</span> - method: <span style=\"color:#ffffff\">$method</span> - ".($session->logged_in() ? "<span style=\"color:#ffffff\">logged in</span>" : "not logged in")."</pre>");
		}
	}
}
