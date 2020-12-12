<?php
set_error_handler(function($errno, $errstr, $errfile, $errline ){
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
try {
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/users.php';
$pet = Pet::fromDatabase($_GET['id']);
$title = "New proposal";

if (isset($_SESSION['username'])) {
    $user = User::fromDatabase($_SESSION['username']);
}

require_once 'templates/common/header.php';
require_once 'templates/pets/add_proposal.php';
require_once 'templates/common/footer.php';
}
catch (Exception $e) {
    header( "Location: error.php" );die();
}
