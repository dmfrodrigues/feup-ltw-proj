<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR . '/users.php';

$javascript_files = ["js/handleAdoptionMessages.js", "js/utils_elements.js"];
include_once 'templates/common/header.php';

$adoptionRequest = getAdoptionRequest($_GET['id']);
if(isset($_SESSION['username']) && ($_SESSION['username'] == $adoptionRequest['user'] || $_SESSION['username'] == $adoptionRequest['postedBy'])) {
    include_once 'templates/pets/view_proposal.php';
    drawAdoptionRequestInitialMessage($adoptionRequest);
    $adoptionRequestMessages = getAdoptionRequestMessages($adoptionRequest['id']);
    drawAllOtherMessages($adoptionRequestMessages);
    drawAnswerAdoptionRequest();
}

include_once 'templates/common/footer.php';
