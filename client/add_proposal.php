<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once __DIR__.'/../server/notifications.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/users.php';
$pet = getPet($_GET['id']);
$title = "New proposal";

if (isset($_SESSION['username'])) {
    $user = getUser($_SESSION['username']);
}

require_once 'templates/common/header.php';
require_once 'templates/pets/add_proposal.php';
require_once 'templates/common/footer.php';