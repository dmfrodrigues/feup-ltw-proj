<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';
require_once SERVER_DIR . '/classes/Shelter.php';

$title = "Shelter invitations";

require_once CLIENT_DIR.'/templates/common/header.php';
if(isset($_SESSION['username'])) {
    $shelterInvitations = getUserShelterInvitation($_SESSION['username']);
    require_once CLIENT_DIR.'/templates/users/view_shelter_invitations.php';
    if(!isset($_GET['failed']) && !isset($_GET['errorCode'])){
        echo '<section class="messages-column-body">';
        drawShelterInvitations($shelterInvitations, false);
        echo '</section>';
    }
    else { // Defensive programming
        drawInvitationError();
        die();
    }
}
require_once CLIENT_DIR.'/templates/common/footer.php';
