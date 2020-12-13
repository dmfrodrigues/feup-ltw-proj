<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';

session_start();

$shelter = $_SESSION['username'];

if (isset($shelter) && isset($_SESSION['isShelter'])) {
    deleteShelterInvitation($user, $shelter);
    header("Location: " . PROTOCOL_API_URL."/user/" . $shelter);
}

die();