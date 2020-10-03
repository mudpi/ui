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

$config = json_decode(file_get_contents(MUDPI_PATH_CORE."/mudpi.config"));

$relays = [];

if(isset($config->nodes)) {
	if(isset($config->nodes->relays)) {
			array_push($relays, ...$config->nodes->relays);
	}
}

if(isset($config->relays)) {
	array_push($relays, ...$config->relays);
}

foreach($relays as $relay) {
	if(!isset($relay->key)) {
		$relay->key = slug($relay->name);
	}
	$relay->value = $redis->get($sensor->key);
}


include 'templates/relays.php';

?>