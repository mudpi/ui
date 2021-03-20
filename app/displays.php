<?php
// MudPi Setup Page to help new users with first time configurations
// such as connecting to their home network and installing any other
// depencies based on options picked during setup.
require 'bootstrap.php';

begin_session();
handle_csrf();

set_csrf_token();

//Connecting to Redis server on localhost 
$redis = new Redis(); 
$redis->connect(MUDPI_REDIS_HOST, MUDPI_REDIS_PORT); 

$started_at = strtotime($redis->get("started_at"));

$config = json_decode(file_get_contents(MUDPI_PATH_CORE."/".MUDPI_CONFIG_FILE));

$displays = $config->char_display;
foreach($displays as $display) {
	if(empty($display->name)) {
		$display->name = ucwords(str_replace("_", " ", $display->key));
	}
	if(empty($display->topic)) {
		$display->topic = "char_display/".$display->key;
	}
	
}

include 'templates/displays.php';

?>