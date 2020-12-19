<?php
require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR . '/database/connection.php';
require_once SERVER_DIR . '/classes/Notification.php';
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';
require_once SERVER_DIR . '/errors/errors.php';

$title = "Change password";

$javascript_files = [
    PROTOCOL_CLIENT_URL.'/js/signup.js'
];

require_once CLIENT_DIR.'/templates/common/header.php';
$isLoggedIn = (isset($_SESSION['username']) && $_SESSION['username'] == $user->getUsername());
$hasToken   = (isset($_GET['token']) && PasswordResetToken::check($user->getUsername(), $_GET['token']));

if ($isLoggedIn) require_once CLIENT_DIR.'/templates/users/change_password.php';
if ($hasToken  ) require_once CLIENT_DIR.'/templates/users/reset_password.php';

require_once CLIENT_DIR.'/templates/common/footer.php';