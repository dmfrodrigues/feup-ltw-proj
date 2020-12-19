<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$petId = $_GET['id'];

if (isset($_SESSION['username'])){
    withdrawAdoptionRequest($_SESSION['username'], $petId);
    header("Location: " . PROTOCOL_API_URL . "/pet/$petId");
}

die();