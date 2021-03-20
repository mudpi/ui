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
	"general" => "",
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

if (!empty($config->sensor)){
	foreach($config->sensor as $sensor) {
		if(empty($sensor->name)) {
			$sensor->name = ucwords(str_replace("_", " ", $sensor->key));
		}
		if(empty($sensor->classifier)) {
			$sensor->classifier = "general";
		}
		try {
			$state = $redis->get($sensor->key.'.state');
			if (!empty($state)) {
				$sensor->state = json_decode($state);
			}
			else {
				throw new Exception('No State Found');
			}
		} catch (Exception $e) {
			$sensor->state (object)['component_id' => $sensor->key,
									'state' => 0,
									'updated_at' => '',
									'metadata' => ''];
		}
	}
}



include 'templates/dashboard.php';

?>