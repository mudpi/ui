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

$config = json_decode(file_get_contents(MUDPI_PATH_CORE."/mudpi.config"));

$display_workers = array_merge(array_filter($config->workers, function($v) {
	return strcasecmp($v->type, "display") == 0;
}));

$displays = [];

foreach($display_workers as $worker) {
	array_push($displays, ...$worker->displays);
}



include 'templates/displays.php';

?>