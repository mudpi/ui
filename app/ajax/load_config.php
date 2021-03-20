<?php
namespace Mudpi\Ajax;

require '../bootstrap.php';

begin_session();

// $json_str = file_get_contents('php://input');
// $json_obj = json_decode($json_str, true);

if (!isset($_POST["source"]) || empty($_POST["source"])) {
	response_error('Source ID was not set or invalid.');
	// $_POST["source"] = "unknown";
}

if (!isset($_POST["boots"]) || empty($_POST["boots"])) {
	response_error('Boot count was not set or invalid.');
}

//Todo Change to DATA
if (!isset($_POST["value"]) || empty($_POST["value"])) {
	response_error('Values were not set or invalid.');
} elseif (!is_array($_POST["value"])) {
	$_POST["value"] = [$_POST["value"]];
}

foreach($_POST["value"] as $key => $reading) {
	if (!isset($reading["value"])) {
		response_error('Reading Value was not set or invalid.');
	}

	if (!isset($reading["parsed"]) || empty($reading["parsed"])) {
		//response_error('parsed was not set or invalid.');
		$reading["parsed"] = null;
	}

	if (!isset($reading["sensor"]) || empty($reading["sensor"])) {
		//response_error('sensor was not set or invalid.');
		$reading["sensor"] = "unknown";
	}

	$reading['boots'] = $_POST["boots"];
	$reading['source'] = $_POST["source"];
}


$data = array(
	"time" => date("Y-m-d H:i:s"),
	"value" => $_POST["value"],
	"parsed" => $_POST["parsed"],
	"boots" => $_POST["boots"],
	"source" => $_POST["source"]
);

$old_data = unserialize(file_get_contents("/home/mudpi/sprout.txt"));
$old_data[] = $data;

if(file_put_contents('/home/mudpi/sprout.txt', serialize($old_data))) {
	echo json_encode(['status' => 'OK', 'message' => 'Successfully Saved Readings']);
}
else {
	response_error('Problem Saving the Readings to File');
}

?>

