<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
$pets = Pet::getListedForAdoption();

$javascript_files = ['js/filterPets.js'];

include_once 'templates/common/header.php';
include_once 'templates/pets/list_pets_for_adoption.php';
include_once 'templates/common/footer.php';
