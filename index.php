<?php
require('config.php');

// set up the database
require('vendor/phpDataMapper/Base.php');
require('vendor/phpDataMapper/Adapter/Mysql.php');
try {
	$adapter = new phpDataMapper_Adapter_Mysql($config['mysql_host'], $config['mysql_database'], $config['mysql_username'], $config['mysql_password']);
} catch(Exception $e) {
	echo $e->getMessage();
	exit();
}

?>
