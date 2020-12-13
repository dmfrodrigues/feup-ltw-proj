<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Pet.php';

$petsAdopted = Pet::getAdopted();
$petsForAdoption = Pet::getForAdoption();

require_once CLIENT_DIR.'/templates/common/header.php';
require_once 'templates/main/main.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
