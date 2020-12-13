<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';

$shelter = $_GET['shelter'];

if (isset($_SESSION['username']) && isShelter($shelter)) {
    deleteShelterInvitation($_SESSION['username'], $shelter);

    addNotification($shelter, "invitationOutcome", "The user " . $_SESSION['username'] . " refused your invite to be a collaborator.");
    
    header("Location: " . PROTOCOL_API_URL."/user/" . $_SESSION['username']);
}

die();