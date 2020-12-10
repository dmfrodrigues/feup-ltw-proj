<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
$pet = Pet::fromDatabase($_GET['id']);

if (isset($_SESSION['username'])) {
    $user = getUser($_SESSION['username']);
}

include_once 'templates/common/header.php';
include_once 'templates/pets/add_proposal.php';
include_once 'templates/common/footer.php';