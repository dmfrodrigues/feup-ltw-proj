<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Pet.php';

$title = "Pet album";

$pet = Pet::fromDatabase($_GET['id']);

require_once 'templates/common/header.php';
require_once 'templates/pets/pet_album.php';
require_once 'templates/common/footer.php';