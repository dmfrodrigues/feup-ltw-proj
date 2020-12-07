<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/shelters.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username'])) {
    if(acceptShelterInvite($_SESSION['username'], $shelter))
        header("Location: " . CLIENT_URL . "/profile_shelter.php?username=" . $_SESSION['username']);
    else {
        $errorMsg = urlencode('Proposal can\'t be acccepted because you already belong to a Shelter!');
        header("Location: " . CLIENT_URL . "/view_shelter_invitations.php?failed=1&errorMessage=" . $errorMsg);
    }
}

die();