<?php
namespace Mudpi\Ajax;

require '../bootstrap.php';

begin_session();
handle_csrf();

// $json_str = file_get_contents('php://input');
// $json_obj = json_decode($json_str, true);

if (!isset($_POST["key"]) || empty($_POST["key"]) ) {
	response_error('Key was not set or invalid.');
}

$data = array(
	"data" => '.'.$_POST["key"].".toggle"
);

//Connecting to Redis server on localhost 
$redis = new \Redis(); 
$redis->connect(MUDPI_REDIS_HOST, MUDPI_REDIS_PORT); 

if($redis->publish('action_call', json_encode($data))) {
	echo json_encode(['status' => 'OK', 'message' => 'Successfully Toggled '.$_POST["key"]]);
}
else {
	response_error('Problem Toggling the Relay');
}

?>

