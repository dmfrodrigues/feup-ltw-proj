<?php
require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/errors/errors.php';

$title = "Login";
$token = bin2hex(openssl_random_pseudo_bytes(32));
setcookie("CSRFtoken", $token, time() + 60 * 60 * 24, '/', NULL, NULL, TRUE);

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/authentication/login.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
