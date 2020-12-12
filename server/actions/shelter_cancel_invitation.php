<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/shelters.php';

$user = $_GET['username'];
$shelter = $_SESSION['username'];

if (isset($shelter) && isset($_SESSION['isShelter'])) {
    deleteShelterInvitation($user, $shelter);
    header("Location: " . "../../client/profile.php?username=" . $shelter);
}

die();