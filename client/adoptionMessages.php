<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/users.php';

$title = "Adoption messages";

$javascript_files = ["js/handleAdoptionMessages.js", "js/utils_elements.js"];
require_once 'templates/common/header.php';

$adoptionRequest = getAdoptionRequest($_GET['id']);
if(isset($_SESSION['username']) && ($_SESSION['username'] == $adoptionRequest['user'] || $_SESSION['username'] == $adoptionRequest['postedBy'])) {
    require_once 'templates/pets/view_proposal.php';
    drawAdoptionRequestInitialMessage($adoptionRequest);
    $adoptionRequestMessages = getAdoptionRequestMessages($adoptionRequest['id']);
    drawAllOtherMessages($adoptionRequestMessages);
    drawAnswerAdoptionRequest();
}

require_once 'templates/common/footer.php';
