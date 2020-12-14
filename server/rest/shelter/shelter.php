<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';

// view_shelters.php
$shelter_GET = function(array $args): void {
    $auth = Authentication\check(true);
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::READ, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_shelters.php';
};

// propose_to_collaborate.php
$shelter_id_propose_userId_GET = function(array $args): void {
    $shelterId = $args[1];
    $shelter = Shelter::fromDatabase($shelterId);
    $userId = $args[3];
    $user = User::fromDatabase($userId);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET,
        Authorization\Method::READ,
        $auth,
        null
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/propose_to_collaborate.php';
};

// view_potential_collaborators.php
$shelter_potential_GET = function(array $args): void {
    $auth = Authentication\check(true);
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::READ, $auth, null);
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_potential_collaborators.php';
};

$shelter_id_invitations_GET = function(array $args): void {
    $shelterId = $args[1];
    $shelter = Shelter::fromDatabase($shelterId);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::SHELTER_INVITATION,
        Authorization\Method::READ,
        $auth,
        null
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_my_shelter_invitations.php';
};
