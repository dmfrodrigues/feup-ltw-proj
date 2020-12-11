<?php
    include_once SERVER_DIR . '/users.php';

$adoptionMsg_GET = function($args){
    $reqId = intval($args[1]);
    $adoptionMessages = getAdoptionRequestMessages($reqId);
    print_result($adoptionMessages);
};