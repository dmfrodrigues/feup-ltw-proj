<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/AdoptionRequest.php';

$title = "Pet Proposals";

require_once CLIENT_DIR.'/templates/common/header.php';
if(isset($_SESSION['username'])) {
    $adoptionRequests = $pet->getAdoptionRequests();
    require_once CLIENT_DIR.'/templates/pets/view_proposal.php';
    echo '<section class="messages-column-body">';
    drawProposals($adoptionRequests);
    echo '</section>';
}
require_once CLIENT_DIR.'/templates/common/footer.php';