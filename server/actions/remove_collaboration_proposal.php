<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';

$shelter = $_SESSION['username'];
$user = $_GET['username'];

if (isset($_SESSION['isShelter']) && isset($shelter)) {
    deleteShelterInvitation($user, $shelter);
    header("Location: " . PROTOCOL_CLIENT_URL."/profile.php?username=" . $shelter);
}

die();