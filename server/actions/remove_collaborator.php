<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/shelters.php';

$user = $_GET['username'];

if (isset($_SESSION['isShelter']) && isset($_SESSION['username']) ) {
    leaveShelter($user);
    header("Location: " . "../../client/profile.php?username=" . $_SESSION['username']);
}

die();