<?php
session_start();
session_regenerate_id(true);

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';

$title = "Adoption messages";

$javascript_files = ["js/handleAdoptionMessages.js", "js/utils_elements.js"];
require_once CLIENT_DIR.'/templates/common/header.php';

$adoptionRequest = getAdoptionRequest($_GET['id']);
if(isset($_SESSION['username']) && ($_SESSION['username'] == $adoptionRequest['user'] || $_SESSION['username'] == $adoptionRequest['postedBy'])) {
    require_once CLIENT_DIR.'/templates/pets/view_proposal.php';
    drawAdoptionRequestInitialMessage($adoptionRequest);
    $adoptionRequestMessages = getAdoptionRequestMessages($adoptionRequest['id']);
    drawAllOtherMessages($adoptionRequestMessages);
    drawAnswerAdoptionRequest();
}

require_once CLIENT_DIR.'/templates/common/footer.php';
