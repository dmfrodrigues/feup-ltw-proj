<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';

// view_shelters.php
$shelter_GET = function(array $args): void {
    $auth = Authentication\check();
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::READ, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_shelters.php';
};

// propose_to_collaborate.php
$shelter_id_propose_GET = function(array $args): void {
    $auth = Authentication\check();
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::READ, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/propose_to_collaborate.php';
};

// view_potential_collaborators.php
$shelter_id_potential_GET = function(array $args): void {
    $auth = Authentication\check();
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::READ, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_potential_collaborators.php';
};
