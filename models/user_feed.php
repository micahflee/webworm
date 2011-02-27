<?php

class UserFeedModel extends phpDataMapper_Base {
    protected $_datasource = "user_feeds";
		
    public $id = array('type' => 'int', 'primary' => true, 'serial' => true);
		public $user_id = array('type' => 'int', 'required' => true);
		public $feed_id = array('type' => 'int', 'required' => true);
    public $date_created = array('type' => 'datetime');
}

$models['user_feed'] = new UserFeedModel($adapter);
$models['user_feed']->migrate();
