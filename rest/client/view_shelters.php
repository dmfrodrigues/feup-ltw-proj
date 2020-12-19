<?php
include_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
include_once SERVER_DIR.'/database/connection.php';
include_once SERVER_DIR.'/classes/Notification.php';
include_once SERVER_DIR.'/classes/Shelter.php';

$shelters = getAllShelters();
$title = "Shelters";

require_once 'templates/common/header.php';
require_once 'templates/shelters/view_shelters.php';
require_once 'templates/common/footer.php';