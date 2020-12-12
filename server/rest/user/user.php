<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';

$user_PUT = function(array $args): void{
    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::READ   ,
        $auth,
        null
    );

    $_PUT = getPUT();
    $user = new User();
    try{
        $user->setUsername($_PUT['username']);
        $user->setPassword($_PUT['password'], false);
        $user->setName    ($_PUT['name'    ]);
    } catch(InvalidArgumentException $e){
        http_response_code(400);
        die();
    }
    try {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $_PUT['username'])) 
            throw new SignUpException(4);
            
        if(!preg_match('/^(?=.*[!@#$%^&*)(+=._-])(?=.*[A-Z])(?=.{7,}).*$/', $_PUT['password'])) 
            throw new SignUpException(5);
        
        $user->addToDatabase();
        print_result(array('success' => true));

    } catch(SignUpException $e) {
        print_result(array('success' => false, 'errorCode' => $e->errorCode));
        die();
    } catch(UserAlreadyExistsException $e){
        http_response_code(409);
        die();
    }

    $_SESSION['username'] = $user->getUsername();
};

$user_id_GET = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::READ   ,
        $auth,
        $user
    );

    if($user == null){ http_response_code(404); die(); }
    print_result($user);
};

$user_id_PUT = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);
    if($user == null){ http_response_code(404); die(); }

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::READ   ,
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
    if($user == null){ http_response_code(404); die(); }

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

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::READ   ,
        $auth,
        $user
    );

    if($user == null){ http_response_code(404); die(); }
    $ret = $user->getPictureUrl();
    if($ret  == null) $ret = PROTOCOL_CLIENT_URL . '/resources/img/no-image.svg';
    header("Location: {$ret}");
    exit();
};

$user_id_photo_PUT = function(array $args): void{
    $username = $args[1];
    $user = User::fromDatabase($username);
    if($user == null){ http_response_code(404); die(); }

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::PROFILE,
        Authorization\Method  ::WRITE  ,
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
        Authorization\Method  ::WRITE  ,
        $auth,
        $user
    );

    try{
        deleteUserPhoto($username);
        http_response_code(204);
    } catch(CouldNotDeleteFileException $e){
        http_response_code(404); die();
    }
};
