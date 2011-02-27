<?php

class ApplicationController {
	protected $_before_filters;

	public function add_before_filter($method_name) {
		if($this->_before_filters == null) $this->_before_filters = array();
		array_push($this->_before_filters, $method_name);
	}

	public function run_before_filters() {
		$continue = true;
		foreach($this->_before_filters as $method_name) {
			if(method_exists($this, $method_name)) {
				if($this->$method_name() === false) $continue = false;
			}
		}
		return $continue;
	}
}

$controllers['application'] = new ApplicationController();

