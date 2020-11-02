<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
$pet = getPet($_GET['id']);

include_once 'templates/common/header.php';
include_once 'templates/pets/edit_pet.php';
include_once 'templates/common/footer.php';
