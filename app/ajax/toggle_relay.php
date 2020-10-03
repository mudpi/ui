<?php
namespace Mudpi\Ajax;

require '../bootstrap.php';

begin_session();
handle_csrf();

// $json_str = file_get_contents('php://input');
// $json_obj = json_decode($json_str, true);

if (!isset($_POST["topic"]) || empty($_POST["topic"]) ) {
	response_error('Topic was not set or invalid.');
}

$data = array(
	"event" => "Toggle", //Toggle, Switch
	"data" => Null
);

//Connecting to Redis server on localhost 
$redis = new \Redis(); 
$redis->connect(MUDPI_REDIS_HOST, MUDPI_REDIS_PORT); 

if($redis->publish($_POST["topic"], json_encode($data))) {
	echo json_encode(['status' => 'OK', 'message' => 'Successfully Toggled Relay']);
}
else {
	response_error('Problem Toggling the Relay');
}

?>

