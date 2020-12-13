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

$user = $_GET['username'];
$shelter = $_SESSION['username'];

if (isset($shelter) && isset($_SESSION['isShelter'])) {
    deleteShelterInvitation($user, $shelter);
    header("Location: " . PROTOCOL_CLIENT_URL."/profile.php?username=" . $shelter);
}

die();