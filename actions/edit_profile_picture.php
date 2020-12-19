<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';

if($user->getUsername() != $_SESSION['username']){
    header_location("/user/{$_SESSION['username']}");
}

$file = $_FILES['profile_picture'];

try{
    $user->setPicture($file);

    header_location("/user/{$user->getUsername()}");
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request", true, 400);
}
