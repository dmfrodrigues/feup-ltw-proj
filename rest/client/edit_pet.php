<?php
require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Pet.php';

$title = "Edit pet";

$javascript_files = [
    'rest/client/js/utils_elements.js',
    'rest/client/js/editPetImage.js'
];

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/edit_pet.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
