<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Pet.php';
$pets = Pet::getForAdoption();
$title = "Pets";

$javascript_files = ['js/filterPets.js'];

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/list_pets_for_adoption.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
