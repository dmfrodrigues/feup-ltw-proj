<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/Pet.php';
$pet = Pet::fromDatabase($_GET['id']);

$title = "Edit pet";

$javascript_files = ['js/utils_elements.js', 'js/editPetImage.js'];

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/edit_pet.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
