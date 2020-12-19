<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';

if($user->getUsername() != $_SESSION['username']){
    header("Location: " . PROTOCOL_SERVER_URL . "/user/{$_SESSION['username']}");
}

try{
    deleteUserPhoto($user->getUsername());

    header("Location: " . PROTOCOL_SERVER_URL . "/user/{$user->getUsername()}");
} catch(CouldNotDeleteFileException $e){
    echo "Could not delete file";
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request", true, 400);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 500 Internal Server Error", true, 500);
}
