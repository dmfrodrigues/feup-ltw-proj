<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR . '/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';
require_once SERVER_DIR . '/classes/Shelter.php';

$title = "Edit profile";

require_once CLIENT_DIR.'/templates/common/header.php';

if ($_SESSION['username']) {
    require_once CLIENT_DIR.'/templates/users/edit_profile.php';
    editProfile($user);
}

require_once CLIENT_DIR.'/templates/common/footer.php';