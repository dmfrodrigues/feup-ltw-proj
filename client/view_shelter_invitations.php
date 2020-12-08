<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/shelters.php';

include_once 'templates/common/header.php';
if(isset($_SESSION['username'])) {
    $shelterInvitations = getUserShelterInvitation($_SESSION['username']);
    include_once 'templates/shelters/view_shelter_invitations.php';
    if(!isset($_GET['failed']) && !isset($_GET['errorCode']))
        drawShelterInvitations($shelterInvitations);
    else { // Defensive programming
        drawInvitationError();
        die();
    }
}
include_once 'templates/common/footer.php';