<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/users.php';
require_once SERVER_DIR.'/shelters.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username']) && isShelter($shelter)) {
    deleteShelterInvitation($_SESSION['username'], $shelter);
    header("Location: " . "../../client/profile.php?username=" . $_SESSION['username']);
}

die();