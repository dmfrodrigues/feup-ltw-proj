<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/shelters.php';
require_once SERVER_DIR.'/errors/errors.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username']) && isShelter($shelter)) {
    if(acceptShelterInvite($_SESSION['username'], $shelter)) {
        
        addNotification($shelter, "invitationOutcome", "The user " . $_SESSION['username'] . " accepted your invite to be a collaborator.");

        header("Location: " . "../../client/profile.php?username=" . $_SESSION['username']); 
        die();
    }    
}

header("Location: " . "../../client/view_shelter_invitations.php?failed=1&errorCode=1");

die();