<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/pets.php';
$pet = Pet::fromDatabase($_GET['id']);

$title = "Edit pet";

$javascript_files = ['js/utils_elements.js', 'js/editPetImage.js'];

require_once 'templates/common/header.php';
require_once 'templates/pets/edit_pet.php';
require_once 'templates/common/footer.php';
