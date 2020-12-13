<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';

// adoptionMessages.php
$adoptionRequest_id_messages_GET = function(array $args): void {
    $id = $args[1];
    $pet = Pet::fromDatabase($id);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::READ, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/adoptionMessages.php';
};
