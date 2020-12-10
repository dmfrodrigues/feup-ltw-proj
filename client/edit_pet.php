<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/notifications.php';
include_once SERVER_DIR.'/pets.php';
$pet = Pet::fromDatabase($_GET['id']);

$javascript_files = ['js/utils_elements.js', 'js/editPetImage.js'];

include_once 'templates/common/header.php';
include_once 'templates/pets/edit_pet.php';
include_once 'templates/common/footer.php';
