<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';
$title = "Proposals";

require_once 'templates/common/header.php';
if(isset($_SESSION['username'])) {
    $adoptionRequests = User::fromDatabase($_SESSION['username'])->getAdoptionRequestsToMe();
    require_once 'templates/pets/view_proposal.php';
    drawProposals($adoptionRequests);
}
require_once 'templates/common/footer.php';
