<?php
//Helper Functions Used Across the App
function begin_session() {
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}

function handle_csrf() {
	if (request_needs_validation()) {
		if (!validate_csrf_token()) {
			error_log('CSRF Violation ' . $_SERVER['REMOTE_ADDR'] . ' - ' . $_SERVER['REMOTE_HOST'] . ' - ' . $_SERVER['REMOTE_USER']);
			handle_invalid_csrf();
		}
	}
}

//Validate the request method
function request_needs_validation() {
	$request_method = strtolower($_SERVER['REQUEST_METHOD']);
	return in_array($request_method, [ "post", "put", "patch", "delete" ]);
}

function set_csrf_token() {
	if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
}

function csrf_field() {
	$token = htmlspecialchars($_SESSION['csrf_token']);
	return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

function csrf_meta() {
	$token = htmlspecialchars($_SESSION['csrf_token']);
	return '<meta name="csrf_token" content="' . $token . '">';
}

function csrf_token() {
	$token = htmlspecialchars($_SESSION['csrf_token']);
	return $token;
}

function validate_csrf_token() {
	$csrf_token = $_POST['csrf_token'] ?? null;
	$header_token =  $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

	//Check if a token is even set
	if (empty($csrf_token) && empty($header_token)) {
		return false;
	}

	//Check to see if there is a post token otherwise use the server token. 
	$request_token = $csrf_token ?: $header_token;

	return hash_equals($_SESSION['csrf_token'], $request_token);
}

function handle_invalid_csrf()
{
	response_error('Invalid CSRF token or session expired');
}

function response_error($error = "There was an error.")
{
	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: text/plain');
	echo $error;
	exit;
}

//Used to parse general configrations like key value files or lighthttp
function parseConfig($configuration) {
	$config = array();
	foreach ($configuration as $line) {
		$line = trim($line);
		if ($line == "" || $line[0] == "#") {
			continue; //skip empty lines and comments
		}
		//Fancy way to spit config file on the '=' and trim the values
		list($option, $value) = array_map("trim", explode("=", $line, 2));

		if (empty($config[$option])) {
			$config[$option] = $value ?: null;
		} else {
			if (!is_array($config[$option])) {
				$config[$option] = [ $config[$option] ];
			}
			$config[$option][] = $value;
		}
	}
	return $config;
}

// Helpers for system commands and fetching system info
function getConnectedNetworkName() {
	exec("iwgetid ". MUDPI_WIFI_INTERFACE . ' -r', $name);
	return $name;
}

function getNetworkInfo() {
	exec("ls /sys/class/net | grep -v lo", $interfaces);
	foreach ($interfaces as $interface) {
		exec("ip a show $interface", $$interface);
	}
	return $interfaces;
}

function reboot() {
	$result = shell_exec("sudo /sbin/reboot");
	return $result;
}

function shutdown() {
	$result = shell_exec("sudo /sbin/shutdown -h now");
	return $result; //Not going to get this message ever...
}

function getCurrentDirectory() {
	exec('pwd', $directory);
	return $directory;
}

function switchDirectory($directory) {
	if (isset($directory)) {
		exec("cd ".$directory);
	}
}

function makeDirectory($directory, $createParentDirectories = false) {
	if (isset($directory)) {
		if($createParentDirectories) {
			$result = exec("mkdir ".$directory. " -p");
		}
		else {
			$result = exec("mkdir ".$directory);
		}
		return $result;
	}
	return false;
}

function listFiles($path = null) {
	if($path) {
		exec("ls ".$path." -lah", $results);
	}
	else {
		exec("ls -lah", $results);
	}
	return $results;
}

function timeForHumans ($time)
{

	$time = time() - $time; // to get the time since that moment
	$time = ($time<1)? 1 : $time;
	$tokens = array (
		31536000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hour',
		60 => 'minute',
		1 => 'second'
	);

	foreach ($tokens as $unit => $text) {
		if ($time < $unit) continue;
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
	}
}

function slug($string, $spacer = "_"){
	return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', $spacer, $string), $spacer));
}

function parseReading($type = "general", $value = null) {
	$type = strtolower($type);
	switch($type) {
		case "humidity":
			return json_decode($value);
			break;
		case "t9602":
			// {"temperature": 66.5, "humidity": 59.9}
			return json_decode($value);
			break;
		case "bme680":
			// {"temperature": 66.5, "humidity": 59.9, "pressure": 994.01, "gas": 36187, "altitude": 161.457}
			return json_decode($value);
			break;
		case "soil":
			return [ "Moisture" => $value ];
			break;
		case "float":
			return [ "Float" => $value ];
			break;
		case "temperature":
			return [ "Temperature" => $value ];
			break;
		case "rain":
			return [ "Rain" => $value ];
			break;
		default:
			return [ "General" => $value ];
			break;
	}
}

function is_json($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}