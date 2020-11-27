<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
$pets = getPetsListedForAdoption();

$javascript_files = ['js/filterPets.js'];

include_once 'templates/common/header.php';
?> <h1>Pets available for adoption</h1> <?php
include_once 'templates/pets/list_pets.php';
include_once 'templates/common/footer.php';
