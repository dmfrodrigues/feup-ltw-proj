<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once __DIR__.'/../server/notifications.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/shelters.php';
$title = "Shelter invitations";
include_once 'templates/common/header.php';
if(isset($_SESSION['username'])) {
    $shelterInvitations = getUserShelterInvitation($_SESSION['username']);
    include_once 'templates/users/view_shelter_invitations.php';
    if(!isset($_GET['failed']) && !isset($_GET['errorCode']))
        drawShelterInvitations($shelterInvitations, false);
    else { // Defensive programming
        drawInvitationError();
        die();
    }
}
include_once 'templates/common/footer.php';
