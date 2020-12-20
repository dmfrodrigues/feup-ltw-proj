<?php

chdir(__DIR__);

// DIR constants
define('SERVER_DIR', __DIR__);
define('API_DIR', SERVER_DIR.'/rest');
define('CLIENT_DIR', API_DIR.'/client');

require_once SERVER_DIR.'/utils.php';

// URL constants
define('SERVER_NAME', $_SERVER['SERVER_NAME']);
if(strpos( $_SERVER['SERVER_SOFTWARE'], 'Apache') !== false){
    $this_file_url = $_SERVER['PHP_SELF'];
    $request_uri   = $_SERVER["REQUEST_URI"];
    if(endsWith($this_file_url, $request_uri)){
        $this_file_url = substr(
            $this_file_url,
            0,
            strlen($this_file_url)-strlen($request_uri)
        );
    }
    $server_url_path = pathinfo($this_file_url, PATHINFO_DIRNAME);
} else if(strpos( $_SERVER['SERVER_SOFTWARE'], 'PHP') !== false){
    $server_url_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__);
}
if(strlen($server_url_path) > 0 && $server_url_path[0] === '/') $server_url_path = substr($server_url_path, 1);
define('SERVER_URL_PATH', ($server_url_path === '' ? '' : '/').$server_url_path);

define('PROTOCOL', get_protocol());

// Picture sizes
define('USER_PICTURE_MAX_SIZE', 1000000);
define('PET_PICTURE_MAX_SIZE', 1000000);
define('COMMENT_PICTURE_MAX_SIZE', 1000000);

// Time zone
date_default_timezone_set('UTC');

// Include connection
require_once SERVER_DIR . '/database/connection.php';
