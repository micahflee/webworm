<?php

class User extends ActiveRecord\Model {
	// relationships
	static $has_many = array(
		array('feeds', 'through' => 'user_feeds')
	);

	// validations
	static $validates_presence_of = array(
		array('username'),
		array('password')
	);
	static $validates_uniqueness_of = array(
		array('username')
	);

	// filters
	static $before_create = array('hash_password');
	function hash_password() {
		global $phpass;
		$this->password = $phpass->HashPassword($this->password);
	}

	// methods
	function verify_password($password) {
		global $phpass;
		return $phpass->CheckPassword($password, $this->password);
	}
}

