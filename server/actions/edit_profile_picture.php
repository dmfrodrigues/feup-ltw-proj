<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';

if($_GET['username'] != $_SESSION['username']){
    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_SESSION['username']}");
}

$file = $_FILES['profile_picture'];

try{
    $user = User::fromDatabase($_GET['username']);
    $user->setPicture($file);

    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_GET['username']}");
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request", true, 400);
}
