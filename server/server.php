<?php
require_once __DIR__ . '/server_constants.php';

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

define('USER_PICTURE_MAX_SIZE', 1000000);
define('PET_PICTURE_MAX_SIZE', 1000000);
define('COMMENT_PICTURE_MAX_SIZE', 1000000);

function path2url($file, $Protocol=PROTOCOL): string {
    return
        $Protocol .
        str_replace(SERVER_DIR, SERVER_URL, $file);
}

class CouldNotDeleteFileException extends RuntimeException{}
