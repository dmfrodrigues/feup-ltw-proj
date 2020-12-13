<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';

// add_proposal.php
$adoptionRequest_new_GET = function(array $args): void {
    $auth = Authentication\check();
    Authorization\checkAndRespond(Authorization\Resource::ADOPTION_REQUEST, Authorization\Method::WRITE, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/add_proposal.php';
};

// adoptionMessages.php
$adoptionRequest_id_messages_GET = function(array $args): void {
    $auth = Authentication\check();
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::READ, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/adoptionMessages.php';
};
