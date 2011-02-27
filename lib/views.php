<?php
require('vendor/mustache.php/Mustache.php');

class Views {
	// the mustache object
	protected $_m;

	// constructor
	public function __construct() {
		$this->_m = new Mustache;
	}

	// the template, set this before calling render to change it
	public $template = "layout";

	// render a view
	public function render($filename, $data = array()) {
		$content = $this->render_partial($filename, $data, $this->template);
		return $this->render_partial($this->template, array('content' => $content));
	}

	// render a view without the template
	public function render_partial($filename, $data = array()) {
		global $config;

		// set up data to pass into view
		$webroot = empty($config['webroot']) ? '' : $config['webroot'];
		$data = array_merge($data, array('webroot' => $webroot));

		// render view
		$html = file_get_contents("views/$filename.html");
		return $this->_m->render($html, $data);
	}
}
