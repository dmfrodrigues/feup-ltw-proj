<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';

$title = "Shelter invitations";

require_once 'templates/common/header.php';
if(isset($_SESSION['username'])) {
    $shelterInvitations = getUserShelterInvitation($_SESSION['username']);
    require_once 'templates/users/view_shelter_invitations.php';
    if(!isset($_GET['failed']) && !isset($_GET['errorCode']))
        drawShelterInvitations($shelterInvitations, false);
    else { // Defensive programming
        drawInvitationError();
        die();
    }
}
require_once 'templates/common/footer.php';
