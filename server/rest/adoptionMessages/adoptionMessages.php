<?php
    require_once SERVER_DIR . '/users.php';

$adoptionMsg_GET = function($args){
    $reqId = intval($args[1]);
    $initialMessage = getAdoptionRequest($reqId);
    $adoptionMessages = getAdoptionRequestMessages($reqId);
    array_unshift($adoptionMessages, $initialMessage);
    print_result($adoptionMessages);
};
