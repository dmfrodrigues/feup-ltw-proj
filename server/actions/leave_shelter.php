<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/shelters.php';
include_once CLIENT_URL.'/errors/errors.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username']) && !isset($_SESSION['isShelter'])) {
    $userShelter = getUserShelter($_SESSION['username']);
    if ($shelter === $userShelter) {
        leaveShelter($_SESSION['username']);
        header("Location: " . "../../client/profile.php?username=" . $_SESSION['username']); 
        die();
    }
}

header("Location: " . "../../client/index.php");

die();