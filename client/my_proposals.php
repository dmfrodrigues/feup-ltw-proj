<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';

$title = "My proposals";

$user = User::fromDatabase($_SESSION['username']);
$adoptionRequests = $user->getAdoptionRequestsToOthers();

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/view_proposal.php';
drawMyProposals($adoptionRequests);
require_once CLIENT_DIR.'/templates/common/footer.php';