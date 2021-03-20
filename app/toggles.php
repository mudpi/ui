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

$config = json_decode(file_get_contents(MUDPI_PATH_CORE."/".MUDPI_CONFIG_FILE));

foreach($config->toggle as $toggle) {
	if(empty($toggle->name)) {
		$toggle->name = ucwords(str_replace("_", " ", $toggle->key));
	}
	if(empty($toggle->topic)) {
		$toggle->topic = "toggle/".$toggle->key;
	}
	$toggle->value = $redis->get($toggle->key.'.state');
}


include 'templates/toggles.php';

?>