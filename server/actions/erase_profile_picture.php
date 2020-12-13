<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';

session_start();

if($_GET['username'] != $_SESSION['username']){
    header("Location: " . PROTOCOL_API_URL . "/user/{$_SESSION['username']}");
}

try{
    deleteUserPhoto($_GET['username']);

    header("Location: " . PROTOCOL_API_URL . "/user/{$_GET['username']}");
} catch(CouldNotDeleteFileException $e){
    echo "Could not delete file";
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request", true, 400);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 500 Internal Server Error", true, 500);
}
