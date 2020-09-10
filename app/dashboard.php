<?php
// MudPi Setup Page to help new users with first time configurations
// such as connecting to their home network and installing any other
// depencies based on options picked during setup.
require 'bootstrap.php';

begin_session();
handle_csrf();

set_csrf_token();

setcookie("setup_completed", date("d-m-Y H:i:s"), time() + (3600 * 12)); // expires in 12hrs

//Connecting to Redis server on localhost 
$redis = new Redis(); 
$redis->connect('127.0.0.1', 6379); 
echo "Connection to server sucessfully"; 
// Get the stored keys and print it 
$redis_keys = $redis->keys("*"); 

include 'templates/dashboard.php';

?>