<?php

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/notifications.php';

$title = "Notifications";

require_once CLIENT_DIR.'/templates/common/header.php';

if(isset($_SESSION['username']) && $_SESSION['username'] == $user->getUsername()) {
    $notifications = getNotifications($_SESSION['username']);
    require_once CLIENT_DIR.'/templates/notifications/view_notifications.php';
}
    
require_once CLIENT_DIR.'/templates/common/footer.php';