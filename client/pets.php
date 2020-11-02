<?php
session_start();

include_once __DIR__.'/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
$pets = getPets();

include_once 'templates/common/header.php';
include_once 'templates/pets/list_pets.php';
include_once 'templates/common/footer.php';
