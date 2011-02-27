<?php

class ApplicationController {
	protected $_before_filters;

	public function __construct() {
		$_before_filters = array();
	}

	public function add_before_filter($method_name) {
		array_push($this->_before_filters, $method_name);
	}

	public function run_before_filters() {
		foreach($this->_before_filters as $method_name) {
			if(method_exists(__CLASS__, $method_name)) {
				$this->$method_name();
			}
		}
	}
}

$controllers['application'] = new ApplicationController();

