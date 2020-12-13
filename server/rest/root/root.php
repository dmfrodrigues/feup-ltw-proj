<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';

// index.php
$root_GET = function(array $args): void {
    $auth = Authentication\check(true);
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::READ, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/index.php';
};
