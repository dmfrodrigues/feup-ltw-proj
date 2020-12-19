<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/Shelter.php';

$title = "Edit profile";

require_once CLIENT_DIR.'/templates/common/header.php';

if ($_SESSION['username']) {
    require_once CLIENT_DIR.'/templates/users/edit_profile.php';
    editProfile($user);
}

require_once CLIENT_DIR.'/templates/common/footer.php';