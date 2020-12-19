<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/AdoptionRequest.php';

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
