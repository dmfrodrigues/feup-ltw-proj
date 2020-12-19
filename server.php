<?php
// DIR constants
define('SERVER_DIR', __DIR__);
define('API_DIR', SERVER_DIR.'/rest');
define('CLIENT_DIR', API_DIR.'/client');

// URL constants
define('SERVER_NAME', $_SERVER['SERVER_NAME']);
define('SERVER_URL_PATH', pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME));
require_once SERVER_DIR.'/utils.php';
define('PROTOCOL', get_protocol());

// Picture sizes
define('USER_PICTURE_MAX_SIZE', 1000000);
define('PET_PICTURE_MAX_SIZE', 1000000);
define('COMMENT_PICTURE_MAX_SIZE', 1000000);

// Time zone
date_default_timezone_set('UTC');

// Include connection
require_once SERVER_DIR . '/database/connection.php';
