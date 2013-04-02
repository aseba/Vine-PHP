#!/usr/bin/php
<?php

$params = array();

foreach($argv as $possibleParam) {
	preg_match("/^--(?'paramName'[a-zA-Z0-9]*)$/", $possibleParam, $match);
	if(isset($match['paramName'])) {
		$params[] = $match['paramName'].':';
	}
}
$params = getopt(null, $params);

function usage() {
	die("Usage: --username email --password password --tag cats");
}

if(!in_array('username', array_keys($params))) {
	usage();
}
if(!in_array('password', array_keys($params))) {
	usage();
}
if(!in_array('tag', array_keys($params))) {
	usage();
}

require 'vine.php';

Vine::login($params['username'], $params['password']);
$videos = Vine::get_tag($params['tag']);

foreach($videos as $video) {
	echo $video->videoUrl . "\n";
}

?>
