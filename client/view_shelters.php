<?php
session_start();

include_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
include_once SERVER_DIR.'/connection.php';
include_once __DIR__.'/../server/notifications.php';
include_once SERVER_DIR.'/Shelter.php';

$shelters = getAllShelters();
$title = "Shelters";

include_once 'templates/common/header.php';
include_once 'templates/shelters/view_shelters.php';
include_once 'templates/common/footer.php';