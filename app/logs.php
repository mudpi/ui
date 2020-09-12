<?php
// MudPi Setup Page to help new users with first time configurations
// such as connecting to their home network and installing any other
// depencies based on options picked during setup.
require 'bootstrap.php';

begin_session();
handle_csrf();

set_csrf_token();

$wpa_config = shell_exec('sudo cat '.MUDPI_CONFIG_WPA_SUPPLICANT);
$mudpi_log = shell_exec('tail -256 '.MUDPI_PATH.'/logs/mudpi.out.log');
$mudpi_error_log = shell_exec('tail -256 '.MUDPI_PATH.'/logs/mudpi.err.log');
$auto_ap_log = shell_exec('tail -256 '.MUDPI_PATH.'/logs/auto_hotspot.log');
$sprout_data = unserialize(file_get_contents("/etc/mudpi/sprout.txt"));

include 'templates/logs.php';

?>

