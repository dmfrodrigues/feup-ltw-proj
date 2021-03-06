<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$title = "Collaborate proposal";

if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])) {
    $shelter = Shelter::fromDatabase($_SESSION['username']);
}

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/shelters/propose_to_collaborate.php';
require_once CLIENT_DIR.'/templates/common/footer.php';