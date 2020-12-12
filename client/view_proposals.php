<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
$title = "Proposals";

require_once CLIENT_DIR.'/templates/common/header.php';
if(isset($_SESSION['username'])) {
    $adoptionRequests = User::fromDatabase($_SESSION['username'])->getAdoptionRequestsToMe();
    require_once CLIENT_DIR.'/templates/pets/view_proposal.php';
    echo '<section class="messages-column-body">';
    drawProposals($adoptionRequests);
    echo '</section>';
}
require_once CLIENT_DIR.'/templates/common/footer.php';
