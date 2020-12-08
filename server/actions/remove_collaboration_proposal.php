<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/shelters.php';

$shelter = $_SESSION['username'];
$user = $_GET['username'];

if (isset($_SESSION['isShelter']) && isset($shelter)) {
    deleteShelterInvitation($user, $shelter);
    header("Location: " . "../../client/profile.php?username=" . $shelter);
}

die();