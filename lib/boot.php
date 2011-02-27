<?php

// start views
require('lib/views.php');
$views = new Views;

// set up the database
require('vendor/phpDataMapper/Base.php');
require('vendor/phpDataMapper/Adapter/Mysql.php');
try {
	$adapter = new phpDataMapper_Adapter_Mysql($config['mysql_host'], $config['mysql_database'], $config['mysql_username'], $config['mysql_password']);
} catch(Exception $e) {
	echo($views->render("database_error", array('error' => $e->getMessage())));
	exit();
}

// load all the models
$dir = opendir('models');
while($filename = readdir($dir)) {
	if($filename == "." || $filename == "..") continue;
	require("models/$filename");
}
closedir($dir);


