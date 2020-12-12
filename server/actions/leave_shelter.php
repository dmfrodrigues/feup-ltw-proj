<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/users.php';
require_once SERVER_DIR.'/shelters.php';
require_once SERVER_DIR.'/errors/errors.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username']) && !isset($_SESSION['isShelter'])) {
    $userShelter = User::fromDatabase($_SESSION['username'])->getShelterId();
    if ($shelter === $userShelter) {
        leaveShelter($_SESSION['username']);
        header("Location: " . "../../client/profile.php?username=" . $_SESSION['username']); 
        die();
    }
}

header("Location: " . "../../client/index.php");

die();