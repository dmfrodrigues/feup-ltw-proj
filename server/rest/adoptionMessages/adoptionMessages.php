<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';

$adoptionMsg_GET = function(array $args) : void {
    $reqId = intval($args[1]);
    $initialMessage = getAdoptionRequest($reqId);
    $adoptionMessages = getAdoptionRequestMessages($reqId);
    array_unshift($adoptionMessages, $initialMessage);
    print_result($adoptionMessages);
};
