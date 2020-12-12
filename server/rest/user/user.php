<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/users.php';

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
    if($ret  == null) $ret = CLIENT_URL . '/resources/img/no-image.svg';
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
    print_result($user->getPictureUrl());
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
