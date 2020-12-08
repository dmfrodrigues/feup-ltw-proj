<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/shelters.php';
include_once CLIENT_URL.'errors/errors.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username'])) {
    if(acceptShelterInvite($_SESSION['username'], $shelter))
        header("Location: " . CLIENT_URL . "/profile_shelter.php?username=" . $_SESSION['username']);
    else
        header("Location: " . CLIENT_URL . "/view_shelter_invitations.php?failed=1&errorCode=1");
}

die();