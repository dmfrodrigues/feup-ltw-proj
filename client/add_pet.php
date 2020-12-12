<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
$title = "New pet";

$javascript_files = ['js/utils_elements.js', 'js/addPet.js'];

require_once 'templates/common/header.php';
require_once 'templates/pets/add_pet.php';
require_once 'templates/common/footer.php';
