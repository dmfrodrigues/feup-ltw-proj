<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/shelters.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username'])) {
    deleteShelterInvitation($_SESSION['username'], $shelter);
    header("Location: " . CLIENT_URL . "/profile_shelter.php?username=" . $_SESSION['username']);
}

die();