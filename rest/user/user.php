<?php
require_once __DIR__ . '/../../server.php';
require_once __DIR__ . '/../../authentication.php';
require_once __DIR__ . '/../../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';
require_once SERVER_DIR . '/classes/PasswordResetToken.php';

$user_PUT = function(array $args): void{
    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::WRITE  ,
        $auth,
        null
    );

    $_PUT = getPUT();
    $user = new User();
    try{
        $user->setUsername($_PUT['username']);
        $user->setPassword($_PUT['password'], false);
        $user->setEmail   ($_PUT['email']);
        $user->setName    ($_PUT['name'    ]);
    } catch(InvalidArgumentException $e){
        my_response_code(400);
        die();
    }
    try {
        $user->addToDatabase();
    } catch(UserAlreadyExistsException $e){
        my_response_code(409);
        die();
    } catch(InvalidUsernameException $e){
        my_response_code(412);
        die();
    }

    $_SESSION['username'] = $user->getUsername();
};

// signup.php
$user_new_GET = function(array $args): void {
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/signup.php';
};

$user_id_GET = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::READ   ,
        $auth,
        $user
    );

    if($user == null){ my_response_code(404); die(); }
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false) print_result($user);
    else require_once CLIENT_DIR.'/profile.php';
};

$user_id_PUT = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);
    if($user == null){ my_response_code(404); die(); }

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::EDIT   ,
        $auth,
        $user
    );

    $_PUT = getPUT();
    editUser(
        $user->getUsername(),
        $_PUT['username'],
        $_PUT['name']
    );
    $_SESSION['username'] = $_PUT['username'];
};

$user_id_DELETE = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);
    if($user == null){ my_response_code(404); die(); }

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::EDIT   ,
        $auth,
        $user
    );

    $user->delete();

    print_result("user/{$user->getUsername()}");
};

$user_id_photo_GET = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);

    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::READ   ,
        null,
        $user
    );

    if($user == null){ my_response_code(404); die(); }
    $ret = $user->getPictureUrl();
    if($ret  == null) $ret = SERVER_URL_PATH.'/rest/client/resources/img/no-image.svg';
    header("Location: {$ret}");
    exit();
};

$user_id_photo_PUT = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);
    if($user == null){ my_response_code(404); die(); }

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::EDIT   ,
        $auth,
        $user
    );

    $file = fopen('php://input', 'r');
    $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWPROFILEPHOTO');
    $tmpFile = fopen($tmpFilePath, 'w');
    while($data = fread($file, 1024)){
        fwrite($tmpFile, $data);
    }

    $user->setPicture($tmpFilePath);
};

$user_id_photo_DELETE = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::EDIT   ,
        $auth,
        $user
    );

    try{
        deleteUserPhoto($username);
        my_response_code(204);
    } catch(CouldNotDeleteFileException $e){
        my_response_code(404); die();
    }
};

$user_id_password_PUT = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);
    $_PUT = getPUT();

    $auth = Authentication\check(true);
    $isSameUser = Authorization\check(Authorization\Resource::PROFILE, Authorization\Method::EDIT, $auth, $user);

    $hasToken = false;
    if(isset($_PUT['token'])){
        $reset = PasswordResetToken::check($username, $_PUT['token']);
        if($reset !== null) $hasToken = true;
    }

    if($isSameUser){
        $user->setPassword($_PUT['password'], false);
        $user->updateDatabase();
    } else if($hasToken){
        $reset->deleteFromDatabase();
        $user->setPassword($_PUT['password'], false);
        $user->updateDatabase();
    } else { my_response_code(403); die(); }
};

// change_password.php
$user_id_password_change_GET = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method::READ,
        $auth,
        $user
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/change_password.php';
};

// edit_profile.php
$user_id_edit_GET = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method::EDIT,
        $auth,
        $user
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/edit_profile.php';
};

$user_id_favorite_PUT = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);
    $_PUT = getPUT();
    $petId = $_PUT['petId'];
    $pet = Pet::fromDatabase($petId);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::FAVORITE_PET,
        Authorization\Method::WRITE,
        $auth,
        null
    );
    
    $pet->addToFavorites($user);
};

$user_id_favorite_id_DELETE = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);
    $petId = $args[3];
    $pet = Pet::fromDatabase($petId);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::FAVORITE_PET,
        Authorization\Method::WRITE,
        $auth,
        null
    );
    
    $pet->removeFromFavorites($user);
};

// view_adopted_pets_by_user.php
$user_id_adopted_GET = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method::READ,
        $auth,
        $user
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_adopted_pets_by_user.php';
};

// my_proposals.php
$user_id_myproposals_GET = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method::EDIT,
        $auth,
        $user
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/my_proposals.php';
};

// notifications.php
$user_id_notifications_GET = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method::EDIT,
        $auth,
        $user
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/notifications.php';
};

// view_proposals.php
$user_id_proposalstome_GET = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method::EDIT,
        $auth,
        $user
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_proposals.php';
};

// view_shelter_invitations.php
$user_id_invitations_GET = function(array $args): void {
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method::EDIT,
        $auth,
        $user
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_shelter_invitations.php';
};

// view_previously_owned_pets.php
$user_id_previouslyOwned_GET = function(array $args): void {
    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::PET,
        Authorization\Method::READ,
        $auth,
        null
    );
    
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/view_previously_owned_pets.php';
};
