<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once __DIR__.'/../server/notifications.php';
include_once SERVER_DIR.'/shelters.php';

$user = getUser($_GET['username']);
$title = "Collaborate proposal";

if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])) {
    $shelter = getShelter($_SESSION['username']);
}

include_once 'templates/common/header.php';
include_once 'templates/shelters/propose_to_collaborate.php';
include_once 'templates/common/footer.php';