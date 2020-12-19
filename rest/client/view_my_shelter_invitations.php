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
require_once SERVER_DIR.'/errors/errors.php';

$title = "Shelter invitations";

require_once CLIENT_DIR.'/templates/common/header.php';

if(isset($_SESSION['isShelter']) && isset($_SESSION['username'])) {
    $invitations = getShelterPendingInvitations($_SESSION['username']);
    require_once CLIENT_DIR.'/templates/users/view_shelter_invitations.php';
    echo '<section class="messages-column-body">';
    drawShelterInvitations($invitations, true);
    echo '</section>';
}

require_once CLIENT_DIR.'/templates/common/footer.php';