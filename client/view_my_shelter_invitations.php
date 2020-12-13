<?php

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR.'/errors/errors.php';

$invitations = getShelterPendingInvitations($_SESSION['username']);
$title = "Shelter invitations";

require_once CLIENT_DIR.'/templates/common/header.php';

if(isset($_SESSION['isShelter']) && isset($_SESSION['username'])) {
    require_once CLIENT_DIR.'/templates/users/view_shelter_invitations.php';
    echo '<section class="messages-column-body">';
    drawShelterInvitations($invitations, true);
    echo '</section>';
}

require_once CLIENT_DIR.'/templates/common/footer.php';