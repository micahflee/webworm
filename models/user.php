<?php

class User extends ActiveRecord\Model {
	static $has_many = array(
		array('user_feeds'),
		array('feeds', 'through' => 'user_feeds')
	);

	static $validates_presence_of = array(
		array('username'),
		array('password')
	);
	
	function password($password) {
		global $phpass;
		return $phpass->HashPassword($password);		
	}
	
	function verify_password($password) {
		global $phpass;
		return $phpass->CheckPassword($password, $this->password);
	}
}

