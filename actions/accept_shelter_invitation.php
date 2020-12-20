<?php

require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/errors/errors.php';

$shelterId = $_GET['shelter'];
$shelter = Shelter::fromDatabase($shelterId);

if (isset($_SESSION['username']) && isShelter($shelterId)) {
    if(acceptShelterInvite($_SESSION['username'], $shelterId)) {

        $userLink = "<a href='user/{$_SESSION['username']}'>{$_SESSION['username']}</a>";
        
        addNotification($shelter, "invitationOutcome", "The user " . $userLink . " accepted your invite to be a collaborator.");

        header_location("/user/{$_SESSION['username']}"); 
        die();
    }    
}

header_location("/user/{$_SESSION['username']}/invitations?failed=1&errorCode=1");

die();