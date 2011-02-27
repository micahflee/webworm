<?php

class FeedModel extends phpDataMapper_Base {
    protected $_datasource = "feeds";
		
    public $id = array('type' => 'int', 'primary' => true, 'serial' => true);
    public $feed_url = array('type' => 'string', 'required' => true);
    public $date_created = array('type' => 'datetime');
}

$Feed = new FeedModel($adapter);
$Feed->migrate();