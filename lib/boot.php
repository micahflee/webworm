<?php

// start the session
require('lib/session.php');

// start views
require('lib/views.php');
$views = new Views;

// start helpers
require('lib/helpers.php');
$helpers = new Helpers;

// set up the database
require('vendor/php-activerecord/ActiveRecord.php');
ActiveRecord\Config::initialize(function($cfg) {
	global $config;
	$cfg->set_model_directory('models');
	$cfg->set_connections(array('development' => $config['mysql_string']));
});

// load all the models
$models = array();
$dir = opendir('models');
while($filename = readdir($dir)) {
	if($filename == "." || $filename == "..") continue;
	require("models/$filename");
}
closedir($dir);

// load all the controllers
$controllers = array();
require('controllers/application.php');
$dir = opendir('controllers');
while($filename = readdir($dir)) {
	if($filename == "." || $filename == ".." || $filename == "application.php") continue;
	require("controllers/$filename");
}
closedir($dir);

// set up phpass password hashing framework
require('vendor/phpass/PasswordHash.php');
$phpass = new PasswordHash(8, false);

