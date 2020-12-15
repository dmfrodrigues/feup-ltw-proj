<?php
set_error_handler(function($errno, $errstr, $errfile, $errline ){
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
try {
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
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
}
catch (Exception $e) {
    header( "Location: error.php" );die();
}
