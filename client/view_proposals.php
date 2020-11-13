<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR . '/users.php';

$adoptionRequests = getAdoptionRequestsOfUserPets($_SESSION['username']);

include_once 'templates/common/header.php';
include_once 'templates/pets/view_proposal.php';
drawProposals($adoptionRequests);
include_once 'templates/common/footer.php';
