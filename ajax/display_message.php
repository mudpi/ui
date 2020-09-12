<?php
namespace Mudpi\Ajax;

require '../bootstrap.php';

begin_session();
handle_csrf();

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

if (!isset($json_obj["message"]) || empty($json_obj["message"])) {
	response_error('Message was not set or invalid.');
	// $json_obj["source"] = "unknown";
}

if (!isset($json_obj["duration"]) || empty($json_obj["duration"]) || !is_numeric($json_obj["duration"])) {
	response_error('Duration was not set or invalid.');
}

if (!isset($json_obj["topic"]) || empty($json_obj["topic"]) ) {
	response_error('Topic was not set or invalid.');
}

$data = array(
	"time" => date("Y-m-d H:i:s"),
	"message" => $json_obj["message"],
	"duration" => $json_obj["duration"],
	"topic" => $json_obj["topic"]
);

//Connecting to Redis server on localhost 
$redis = new Redis(); 
$redis->connect(MUDPI_REDIS_HOST, MUDPI_REDIS_PORT); 

if($redis->publish($data["topic"], $data)) {
	echo json_encode(['status' => 'OK', 'message' => 'Successfully Sent Message to Queue']);
}
else {
	response_error('Problem Sending Message to Queue');
}

?>

