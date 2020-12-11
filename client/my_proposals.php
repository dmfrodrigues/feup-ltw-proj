<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/users.php';

$title = "My proposals";

$adoptionRequests = getAdoptionRequests($_SESSION['username']);

require_once 'templates/common/header.php';
require_once 'templates/pets/view_proposal.php';
drawMyProposals($adoptionRequests);
require_once 'templates/common/footer.php';