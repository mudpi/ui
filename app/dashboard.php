<?php
// MudPi Setup Page to help new users with first time configurations
// such as connecting to their home network and installing any other
// depencies based on options picked during setup.
require 'bootstrap.php';

begin_session();
handle_csrf();

set_csrf_token();

setcookie("setup_completed", date("d-m-Y H:i:s"), time() + (3600 * 12)); // expires in 12hrs

$readingSuffixes = [
	"humidity" => "%",
	"temperature" => "°",
	"soil" => "%",
	"moisture" => "%",
	"float" => "",
	"rain" => "%",
	"altitude" => '\'',
	"pressure" => 'hPa',
	"gas" => 'Ω'
];

//Connecting to Redis server on localhost 
$redis = new Redis(); 
$redis->connect(MUDPI_REDIS_HOST, MUDPI_REDIS_PORT); 

$started_at = strtotime($redis->get("started_at"));

// Get the stored keys and print it 
$redis_keys = $redis->keys("*"); 

$config = json_decode(file_get_contents(MUDPI_PATH_CORE."/".MUDPI_CONFIG_FILE));

if isset($config->sensors){
	foreach($config->sensor as $sensor) {
		if(!isset($sensor->name)) {
			$sensor->name = ucwords(str_replace("_", " ", $sensor->key));
		}
		$sensor->value = parseReading($sensor->classifier, $redis->get($sensor->key.'.state'));
	}
}



include 'templates/dashboard.php';

?>