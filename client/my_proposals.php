<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';

$title = "My proposals";

$user = User::fromDatabase($_SESSION['username']);
$adoptionRequests = $user->getAdoptionRequestsToOthers();

require_once 'templates/common/header.php';
require_once 'templates/pets/view_proposal.php';
drawMyProposals($adoptionRequests);
require_once 'templates/common/footer.php';