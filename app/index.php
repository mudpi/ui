<?php
// MudPi Setup Page to help new users with first time configurations
// such as connecting to their home network and installing any other
// depencies based on options picked during setup.
require 'bootstrap.php';

begin_session();
handle_csrf();

set_csrf_token();

// if (!empty($_COOKIE['setup_completed'])) {
// 	header("Location: dashboard.php");
// }

include 'templates/welcome.php';

?>