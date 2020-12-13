<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/Pet.php';

$title = "Pet album";

$pet = Pet::fromDatabase($_GET['id']);

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/pet_album.php';
require_once CLIENT_DIR.'/templates/common/footer.php';