<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/User.php';

if($_GET['username'] != $_SESSION['username']){
    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_SESSION['username']}");
}

try{
    deleteUserPhoto($_GET['username']);

    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_GET['username']}");
} catch(CouldNotDeleteFileException $e){
    echo "Could not delete file";
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request", true, 400);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 500 Internal Server Error", true, 500);
}
