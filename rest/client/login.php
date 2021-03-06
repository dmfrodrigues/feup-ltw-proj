<?php
require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/errors/errors.php';

$title = "Login";
$token = bin2hex(openssl_random_pseudo_bytes(32));
setcookie('CSRFtoken', $token, [
    'expires' => time() + 60 * 60 * 24,
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'httponly' => true,
    'samesite' => 'strict',
]);


require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/authentication/login.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
