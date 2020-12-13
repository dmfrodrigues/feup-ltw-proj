<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';

session_start();

if($user->getUsername() != $_SESSION['username']){
    header("Location: " . PROTOCOL_API_URL . "/user/{$_SESSION['username']}");
}

$file = $_FILES['profile_picture'];

try{
    $user->setPicture($file);

    header("Location: " . PROTOCOL_API_URL . "/user/{$user->getUsername()}");
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request", true, 400);
}
