<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/shelters.php';
include_once SERVER_DIR.'/errors/errors.php';

$invitations = getShelterPendingInvitations($_SESSION['username']);

include_once 'templates/common/header.php';

if(isset($_SESSION['isShelter']) && isset($_SESSION['username'])) {
    include_once 'templates/users/view_shelter_invitations.php';
    drawShelterInvitations($invitations, true);
}

include_once 'templates/common/footer.php';