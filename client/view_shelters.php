<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/Shelter.php';

$shelters = getAllShelters();
$title = "Shelters";

require_once 'templates/common/header.php';
require_once 'templates/shelters/view_shelters.php';
require_once 'templates/common/footer.php';