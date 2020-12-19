<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
session_regenerate_id(true);
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';

$title = "New pet";

$javascript_files = [
    PROTOCOL_CLIENT_URL.'/js/utils_elements.js',
    PROTOCOL_CLIENT_URL.'/js/addPet.js'
];

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/add_pet.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
