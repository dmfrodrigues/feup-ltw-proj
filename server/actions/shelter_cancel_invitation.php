<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/shelters.php';

$user = $_GET['username'];
$shelter = $_SESSION['username'];

if (isset($shelter) && isset($_SESSION['isShelter'])) {
    deleteShelterInvitation($user, $shelter);
    header("Location: " . "../../client/profile.php?username=" . $shelter);
}

die();