<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/Pet.php';

// pets.php
$pet_GET = function(array $args): void {
    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET,
        Authorization\Method::READ,
        $auth,
        null
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die();      }
    require_once CLIENT_DIR.'/pets.php';
};

// add_pet.php
$pet_new_GET = function(array $args): void {
    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET,
        Authorization\Method::WRITE,
        $auth,
        null
    );

    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/add_pet.php';
};

// adopted_pets.php
$pet_adopted_GET = function(array $args): void {
    $pets = Pet::getAdopted();

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET,
        Authorization\Method::READ,
        $auth,
        null
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/adopted_pets.php';
};

$pet_id_GET = function(array $args): void{
    $id = intval($args[1]);
    $pet = Pet::fromDatabase($id);
    if($pet == null){ my_response_code(404); die(); }
    
    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET ,
        Authorization\Method  ::READ,
        $auth,
        $pet
    );

    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false) print_result($pet);
    else require_once CLIENT_DIR.'/pet.php';
};

$pet_id_DELETE = function(array $args): void {
    $id = intval($args[1]);
    $pet = Pet::fromDatabase($id);
    if($pet == null){ my_response_code(404); die(); }
    
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

// edit_pet.php
$pet_id_edit_GET = function(array $args): void {
    $id = intval($args[1]);
    $pet = Pet::fromDatabase($id);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET,
        Authorization\Method::EDIT,
        $auth,
        $pet
    );

    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/edit_pet.php';
};

// pet_album.php
$pet_id_photo_GET = function(array $args): void {
    $id = $args[1];
    $pet = Pet::fromDatabase($id);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET,
        Authorization\Method::READ,
        $auth,
        $pet
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/pet_album.php';
};

// add_proposal.php
$pet_id_adopt_GET = function(array $args): void {
    $id = $args[1];
    $pet = Pet::fromDatabase($id);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::ADOPTION_REQUEST,
        Authorization\Method::WRITE,
        $auth,
        null
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/add_proposal.php';
};

$pet_id_proposals_GET = function(array $args): void {
    $id = $args[1];
    $pet = Pet::fromDatabase($id);
    $adoptionRequests = $pet->getAdoptionRequests();

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET,
        Authorization\Method::READ,
        $auth,
        $pet
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_pet_adoption_requests.php';
};

