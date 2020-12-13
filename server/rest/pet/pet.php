<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/Pet.php';

// add_pet.php
$pet_new_GET = function(array $args): void {
    $auth = Authentication\check();
    Authorization\checkAndRespond(Authorization\Resource::PET, Authorization\Method::WRITE, $auth, null);
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ http_response_code(415); die(); }
    require_once CLIENT_DIR.'/add_pet.php';
};

$pet_id_GET = function(array $args): void{
    $id = intval($args[1]);
    $pet = Pet::fromDatabase($id);
    if($pet == null){ http_response_code(404); die(); }
    
    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PET ,
        Authorization\Method  ::READ,
        $auth,
        $pet
    );

    print_result($pet);
};

$pet_id_DELETE = function(array $args): void {
    $id = intval($args[1]);
    $pet = Pet::fromDatabase($id);
    if($pet == null){ http_response_code(404); die(); }
    
    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PET  ,
        Authorization\Method  ::WRITE,
        $auth,
        $pet
    );

    $pet->delete();

    print_result("pet/{$pet->getId()}");
};

$pet_id_comments_GET = function(array $args): void{
    $id = intval($args[1]);
    $pet = Pet::fromDatabase($id);
    $ret = $pet->getComments($id);

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::READ  ,
        $auth,
        null
    );

    print_result($ret);
};
