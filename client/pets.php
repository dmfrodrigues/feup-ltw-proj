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
$pets = Pet::getForAdoption();
$title = "Pets";

$javascript_files = ['js/filterPets.js'];

require_once 'templates/common/header.php';
require_once 'templates/pets/list_pets_for_adoption.php';
require_once 'templates/common/footer.php';
}
catch (Exception $e) {
    header( "Location: error.php" );die();
}
