<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';

$shelter = $_SESSION['username'];
$user = User::fromDatabase($_GET['username']);

if (isset($shelter) && isset($_SESSION['isShelter'])) {
    deleteShelterInvitation($user->getUsername(), $shelter);
    header("Location: " . PROTOCOL_API_URL."/user/" . $shelter);
}

die();