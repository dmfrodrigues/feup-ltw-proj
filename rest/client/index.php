<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/Pet.php';

$petsAdopted = Pet::getAdopted();
$petsForAdoption = Pet::getForAdoption();

require_once CLIENT_DIR.'/templates/common/header.php';
require_once 'templates/main/main.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
