<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/shelters.php';
include_once 'errors/errors.php';

$shelterInvitations = getUserShelterInvitation($_SESSION['username']);

include_once 'templates/common/header.php';
include_once 'templates/pets/view_shelter_invitations.php';

if(!isset($_GET['failed']) && !isset($_GET['errorCode']))
    drawShelterInvitations($shelterInvitations);
else
    drawInvitationError();
include_once 'templates/common/footer.php';
