<?php
session_start();
session_regenerate_id(true);

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Pet.php';

$petsAdopted = Pet::getAdopted();
$petsForAdoption = Pet::getForAdoption();

require_once CLIENT_DIR.'/templates/common/header.php';
require_once 'templates/main/main.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
