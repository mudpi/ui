<?php
namespace Mudpi\Ajax;

require '../bootstrap.php';

begin_session();

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

if (!isset($json_obj["source"]) || empty($json_obj["source"])) {
	response_error('Source ID was not set or invalid.');
	// $json_obj["source"] = "unknown";
}

if (!isset($json_obj["boots"]) || empty($json_obj["boots"])) {
	response_error('Boot count was not set or invalid.');
}

//Todo Change to DATA
if (!isset($json_obj["value"]) || empty($json_obj["value"])) {
	response_error('Values were not set or invalid.');
} elseif (!is_array($json_obj["value"])) {
	$json_obj["value"] = [$json_obj["value"]];
}

foreach($json_obj["value"] as $key => $reading) {
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

	$reading['boots'] = $json_obj["boots"];
	$reading['source'] = $json_obj["source"];
}


$data = array(
	"time" => date("Y-m-d H:i:s"),
	"value" => $json_obj["value"],
	"parsed" => $json_obj["parsed"],
	"boots" => $json_obj["boots"],
	"source" => $json_obj["source"]
);

$old_data = unserialize(file_get_contents("/etc/mudpi/sprout.txt"));
$old_data[] = $data;

if(file_put_contents('/etc/mudpi/sprout.txt', serialize($old_data))) {
	echo json_encode(['status' => 'OK', 'message' => 'Successfully Saved Readings']);
}
else {
	response_error('Problem Saving the Readings to File');
}

?>

