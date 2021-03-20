<?php
// Constants used for the entire app. 
// Update these with the correct paths for your specific setup
// If a required constant is not provided here it will be added from defaults.php
define('MUDPI_PI_VERSION', '3.0');
define('MUDPI_COUNTRY_CODE', 'US');
define('MUDPI_WIFI_INTERFACE', 'wlan0');

//Configs and paths
define('MUDPI_PATH', '/home/mudpi');
// define('MUDPI_PATH', '/Users/olixr/Code/mudpi-ui-lite'); # DEBUG
define('MUDPI_CONFIG_FILE', 'mudpi.config');
define('MUDPI_PATH_CORE', MUDPI_PATH.'/core');
// define('MUDPI_PATH_CORE', MUDPI_PATH.'/app'); # DEBUG
define('MUDPI_PATH_NETWORKING', MUDPI_PATH.'/networking');
define('MUDPI_CACHE_PATH', sys_get_temp_dir() . '/mudpi');

define('MUDPI_ADMIN_DETAILS', MUDPI_PATH.'/mudpi.auth');

// Locations of installed services (set to defaults for raspbian)
//WIFI Command Interface (WPA Supplicant)
define('MUDPI_CONFIG_WPA_SUPPLICANT', '/etc/wpa_supplicant/wpa_supplicant.conf');
define('MUDPI_WPA_CTRL_INTERFACE', '/var/run/wpa_supplicant');

//Web servers (nginx & lighttpd)
define('MUDPI_CONFIG_NGINX', '/etc/nginx/nginx.conf');
define('MUDPI_CONFIG_LIGHTTPD', '/etc/lighttpd/lighttpd.conf');
define('MUDPI_PATH_WEB_ROOT', '/var/www/html');
define('MUDPI_PATH_UI',  MUDPI_PATH_WEB_ROOT.'/ui');

// Redis
define('MUDPI_REDIS_HOST', '127.0.0.1');
define('MUDPI_REDIS_PORT', 6379);

//DHCP and AP (dhcpcd & hostapd)
define('MUDPI_CONFIG_DHCPCD', '/etc/dhcpcd.conf');
define('MUDPI_HOSTAPD_CTRL_INTERFACE', '/var/run/hostapd');
define('MUDPI_CONFIG_HOSTAPD', '/etc/hostapd/hostapd.conf');
define('MUDPI_CONFIG_DNSMASQ', '/etc/dnsmasq.conf');
define('MUDPI_DNSMASQ_LEASES', '/var/lib/misc/dnsmasq.leases');