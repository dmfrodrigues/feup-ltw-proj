<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR.'/errors/errors.php';

$invitations = getShelterPendingInvitations($_SESSION['username']);
$title = "Shelter invitations";

require_once 'templates/common/header.php';

if(isset($_SESSION['isShelter']) && isset($_SESSION['username'])) {
    require_once 'templates/users/view_shelter_invitations.php';
    drawShelterInvitations($invitations, true);
}

require_once 'templates/common/footer.php';