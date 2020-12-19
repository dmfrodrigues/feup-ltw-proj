<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$shelter = Shelter::fromDatabase($_GET['shelter']);

if (isset($_SESSION['username']) && isShelter($shelter->getUsername())) {
    deleteShelterInvitation($_SESSION['username'], $shelter->getUsername());

    $userLink = "<a href='user/{$_SESSION['username']}'>{$_SESSION['username']}</a>";

    addNotification($shelter, "invitationOutcome", "The user $userLink refused your invite to be a collaborator.");
    
    header("Location: " . PROTOCOL_SERVER_URL."/user/" . $_SESSION['username']);
}

die();