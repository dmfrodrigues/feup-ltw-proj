<?php
require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Pet.php';

$title = "Adopted pets";

$javascript_files = [
    PROTOCOL_CLIENT_URL.'/js/filterPets.js'
];

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/list_pets_adopted.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
