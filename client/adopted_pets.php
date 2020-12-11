<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/pets.php';
$pets = Pet::getAdopted();

$javascript_files = ['js/filterPets.js'];

require_once 'templates/common/header.php';
require_once 'templates/pets/list_pets_adopted.php';
require_once 'templates/common/footer.php';
