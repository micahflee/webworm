<?php

class Feed extends ActuveRecord\Model {
	static $has_many = array(
		array('user_feeds'),
		array('users', 'through' => 'user_feeds')
	);
}
