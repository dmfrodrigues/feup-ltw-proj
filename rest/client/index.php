<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Pet.php';

$petsAdopted = Pet::getAdopted();
$petsForAdoption = Pet::getForAdoption();

require_once CLIENT_DIR.'/templates/common/header.php';
require_once 'templates/main/main.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
