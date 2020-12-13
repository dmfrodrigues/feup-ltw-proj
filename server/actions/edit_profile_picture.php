<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';

session_start();

if($_GET['username'] != $_SESSION['username']){
    header("Location: " . PROTOCOL_API_URL . "/user/{$_SESSION['username']}");
}

$file = $_FILES['profile_picture'];

try{
    $user = User::fromDatabase($_GET['username']);
    $user->setPicture($file);

    header("Location: " . PROTOCOL_API_URL . "/user/{$_GET['username']}");
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request", true, 400);
}
