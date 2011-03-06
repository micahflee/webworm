<?php

class ApplicationController {
	protected $_before_filters;

	function add_before_filter($func) {
		if($this->_before_filters == null) $this->_before_filters = array();
		array_push($this->_before_filters, $func);
	}

	function run_before_filters() {
		if($this->_before_filters == null) $this->_before_filters = array();
		$continue = true;
		foreach($this->_before_filters as $func) {
			if(is_callable($func)) {
				if($func() === false) $continue = false;
			}
		}
		return $continue;
	}
}

$controllers['application'] = new ApplicationController();

