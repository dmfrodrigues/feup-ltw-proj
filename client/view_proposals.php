<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once __DIR__.'/../server/notifications.php';
require_once SERVER_DIR . '/users.php';
$title = "Proposals";
require_once 'templates/common/header.php';
if(isset($_SESSION['username'])) {
    $adoptionRequests = getAdoptionRequestsOfUserPets($_SESSION['username']);
    require_once 'templates/pets/view_proposal.php';
    drawProposals($adoptionRequests);
}
require_once 'templates/common/footer.php';
