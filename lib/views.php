<?php
require('vendor/mustache.php/Mustache.php');

class Views {
	// the mustache object
	protected $_m;

	public function __construct() {
		$this->_m = new Mustache;
	}

	public function render($filename, $data = array()) {
		$html = file_get_contents("views/$filename.html");
		return $this->_m->render($html, $data);
	}
}
