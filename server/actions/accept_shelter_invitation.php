<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/errors/errors.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username']) && isShelter($shelter)) {
    if(acceptShelterInvite($_SESSION['username'], $shelter)) {
        
        addNotification($shelter, "invitationOutcome", "The user " . $_SESSION['username'] . " accepted your invite to be a collaborator.");

        header("Location: " . PROTOCOL_CLIENT_URL."/profile.php?username=" . $_SESSION['username']); 
        die();
    }    
}

header("Location: " . PROTOCOL_CLIENT_URL."/view_shelter_invitations.php?failed=1&errorCode=1");

die();