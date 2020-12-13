<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';

session_start();

$petId = $_GET['id'];

if (isset($_SESSION['username'])){
    withdrawAdoptionRequest($_SESSION['username'], $petId);
    header("Location: " . PROTOCOL_API_URL . "/pet/$petId");
}

die();