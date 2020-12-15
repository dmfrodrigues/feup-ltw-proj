<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';

// login.php
$login_GET = function(array $args): void {
    $auth = Authentication\check(true);
    if($auth != null){ header("Location: {$_SERVER['HTTP_REFERER']}"); }
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/login.php';
};
