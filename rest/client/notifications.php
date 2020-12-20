<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Notification.php';

$title = "Notifications";

$javascript_files = ['rest/client/js/deleteNotifications.js'];

require_once CLIENT_DIR.'/templates/common/header.php';

if(isset($_SESSION['username']) && $_SESSION['username'] == $user->getUsername()) {
    $notifications = getNotifications($_SESSION['username']);

    require_once CLIENT_DIR.'/templates/notifications/view_notifications.php';
}
    
require_once CLIENT_DIR.'/templates/common/footer.php';