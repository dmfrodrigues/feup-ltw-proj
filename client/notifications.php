<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/users.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/shelters.php';
require_once SERVER_DIR.'/notifications.php';

$title = "Notifications";

require_once 'templates/common/header.php';

if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
    $notifications = getNotifications($_SESSION['username']);
    require_once 'templates/notifications/view_notifications.php';
}
    
require_once 'templates/common/footer.php';