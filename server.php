<?php
require_once __DIR__ . '/server_constants.php';
define('API_DIR', SERVER_DIR.'/rest');
define('API_URL', SERVER_URL.'/rest');

define('CLIENT_DIR', API_DIR.'/client');

require_once SERVER_DIR.'/utils.php';

/**
 * Get protocol.
 * 
 * Borrowed from anon445699
 * (https://stackoverflow.com/questions/4503135/php-get-site-url-protocol-http-vs-https)
 *
 * @return string 
 */
function get_protocol() : string {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol;
}
define('PROTOCOL', get_protocol());

define('PROTOCOL_SERVER_URL', PROTOCOL . SERVER_URL);
define('PROTOCOL_CLIENT_URL', PROTOCOL . CLIENT_URL);
define('PROTOCOL_API_URL', PROTOCOL . API_URL);

define('USER_PICTURE_MAX_SIZE', 1000000);
define('PET_PICTURE_MAX_SIZE', 1000000);
define('COMMENT_PICTURE_MAX_SIZE', 1000000);

date_default_timezone_set('UTC');
