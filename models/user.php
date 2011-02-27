<?php

class UserModel extends phpDataMapper_Base {
	protected $_entityClass = "User";
	protected $_datasource = "users";
	
  public $id = array('type' => 'int', 'primary' => true, 'serial' => true);
  public $username = array('type' => 'string', 'required' => true);
  public $password = array('type' => 'string', 'required' => true);
	public $date_created = array('type' => 'datetime');
}

class User extends phpDataMapper_Entity {
	public function feeds() {
		return $this->query(
			"SELECT * FROM feeds LEFT JOIN user_feeds ON user_feeds.feed_id = feeds.id WHERE user_feeds.user_id = :user_id", 
			array('user_id' => $this->id)
		);
	}
}

$models['user'] = new UserModel($adapter);
$models['user']->migrate();
