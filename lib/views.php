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
		$data = $this->_add_webroot($data);
		$data = $this->_add_content($data, $content);
		echo $this->render_partial($this->template, array('content' => $content));
		exit();
	}

	// render a view without the template
	public function render_partial($filename, $data = array()) {
		$data = $this->_add_webroot($data);
		$html = file_get_contents("views/$filename.html");
		return $this->_m->render($html, $data);
	}

	// private functions
	private function _add_webroot($data) {
		global $config;
		$webroot = empty($config['webroot']) ? '' : $config['webroot'];
		return array_merge($data, array('webroot' => $webroot));
	}
	
	private function _add_content($data, $content) {
		return array_merge($data, array('content' => $content));
	}
}
