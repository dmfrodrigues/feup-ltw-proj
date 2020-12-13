<?php
session_start();
session_regenerate_id(true);

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/notifications.php';

$title = "Notifications";

require_once CLIENT_DIR.'/templates/common/header.php';

if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
    $notifications = getNotifications($_SESSION['username']);
    require_once CLIENT_DIR.'/templates/notifications/view_notifications.php';
}
    
require_once CLIENT_DIR.'/templates/common/footer.php';