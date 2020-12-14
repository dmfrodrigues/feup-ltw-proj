<?php

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';

$title = "Adoption messages";

$javascript_files = [
    PROTOCOL_CLIENT_URL."/js/handleAdoptionMessages.js",
    PROTOCOL_CLIENT_URL."/js/utils_elements.js"
];
require_once CLIENT_DIR.'/templates/common/header.php';

if(isset($_SESSION['username']) && ($_SESSION['username'] == $request->getPet()->getPostedById() || $_SESSION['username'] == $request->getUserId())) {
    require_once CLIENT_DIR.'/templates/pets/view_proposal.php';
    drawAdoptionRequestInitialMessage($request);
    $messages = $request->getAdoptionRequestMessages();
    drawAllOtherMessages($messages);
    drawAnswerAdoptionRequest($request);
}

require_once CLIENT_DIR.'/templates/common/footer.php';
