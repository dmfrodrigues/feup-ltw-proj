<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/shelters.php';
include_once SERVER_DIR.'/notifications.php';

$title = "Notifications";

include_once 'templates/common/header.php';

if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
    $notifications = getNotifications($_SESSION['username']);
    include_once 'templates/notifications/view_notifications.php';
}
    
include_once 'templates/common/footer.php';