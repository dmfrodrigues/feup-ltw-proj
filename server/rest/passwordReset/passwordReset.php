<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/PasswordResetToken.php';

$passwordReset_GET = function(array $args): void {
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/reset_password.php';
};
