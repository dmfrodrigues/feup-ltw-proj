<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/shelters.php';
include_once SERVER_DIR.'/errors/errors.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username']) && isShelter($shelter)) {
    if(acceptShelterInvite($_SESSION['username'], $shelter)) {
        header("Location: " . "../../client/profile.php?username=" . $_SESSION['username']); 
        die();
    }    
}

header("Location: " . "../../client/view_shelter_invitations.php?failed=1&errorCode=1");

die();