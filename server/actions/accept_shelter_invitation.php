<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/errors/errors.php';

$shelterId = $_GET['shelter'];
$shelter = Shelter::fromDatabase($shelterId);

if (isset($_SESSION['username']) && isShelter($shelterId)) {
    if(acceptShelterInvite($_SESSION['username'], $shelterId)) {
        
        addNotification($shelter, "invitationOutcome", "The user " . $_SESSION['username'] . " accepted your invite to be a collaborator.");

        header("Location: " . PROTOCOL_API_URL."/user/{$_SESSION['username']}"); 
        die();
    }    
}

header("Location: " . PROTOCOL_API_URL."/user/{$_SESSION['username']}/invitations?failed=1&errorCode=1");

die();