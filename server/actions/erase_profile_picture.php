<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';

if($_GET['username'] != $_SESSION['username']){
    header("Location: " . CLIENT_URL . "/profile.php?username={$_SESSION['username']}");
}

try{
    eraseUserPicture($_GET['username']);

    header("Location: " . CLIENT_URL . "/profile.php?username={$_GET['username']}");
} catch(CouldNotDeleteFileException $e){
    echo "Could not delete file";
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request", true, 400);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 500 Internal Server Error", true, 500);
}
