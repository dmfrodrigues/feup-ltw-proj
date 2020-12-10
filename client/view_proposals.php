<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/notifications.php';
include_once SERVER_DIR . '/users.php';

include_once 'templates/common/header.php';
if(isset($_SESSION['username'])) {
    $adoptionRequests = getAdoptionRequestsOfUserPets($_SESSION['username']);
    include_once 'templates/pets/view_proposal.php';
    drawProposals($adoptionRequests);
}
include_once 'templates/common/footer.php';
