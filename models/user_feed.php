<?php

class UserFeed extends ActiveRecord\Model {
	static $belongs_to = array(
		array('user'),
		array('feed')
	);
}

