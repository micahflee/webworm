<?php

class UserModel extends phpDataMapper_Base {
	protected $_entityClass = "User";
	protected $_datasource = "users";
	
  public $id = array('type' => 'int', 'primary' => true, 'serial' => true);
  public $username = array('type' => 'string', 'required' => true);
  public $password = array('type' => 'string', 'required' => true);
	public $date_created = array('type' => 'datetime');

	public function password($password) {
		global $phpass;
		return $phpass->HashPassword($password);		
	}

	public function create($data) {
		global $models;

		// validation
		$errors = array();
		if($data['password'] != $data['password2']) {
			array_push($errors, array(
				'field' => 'password',
				'message' => 'Passwords do not match'
			));
		}
		if(empty($data['username'])) {
			array_push($errors, array(
				'field' => 'username',
				'message' => 'Must enter a username'
			));
		}
		if(empty($data['password'])) {
			array_push($errors, array(
				'field' => 'password',
				'message' => 'Must enter a password'
			));
		}
		$user = $models['user']->first(array('username' => $data['username']));
		if($user != false) {
			array_push($errors, array(
				'field' => 'username',
				'message' => 'Username already taken'
			));
		}
		
		// try adding the user
		if(empty($errors)) {
			$user = $models['user']->get();
			$user->username = $_REQUEST['username'];
			$user->password = $models['user']->password($_REQUEST['password']);
			$user->date_created = $models['user']->adapter()->dateFormat();
			if(!$models['user']->save($user)) {
				if(empty($errors)) {
					array_push($errors, array(
						'message' => 'There were errors'
					));
				}
			}
		}

		if(empty($errors)) return true;
		return $errors;
	}
}

class User extends phpDataMapper_Entity {
	public function feeds() {
		global $models;

		return $models['user']->query(
			"SELECT * FROM feeds JOIN user_feeds ON user_feeds.feed_id = feeds.id WHERE user_feeds.user_id = ?", 
			array($this->id)
		);
	}

	public function verify_password($password) {
		global $phpass;
		return $phpass->CheckPassword($password, $this->password);
	}
}

$models['user'] = new UserModel($adapter);
$models['user']->migrate();
