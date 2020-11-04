<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';

if($_GET['username'] != $_SESSION['username']){
    header("Location: profile.php?username={$_SESSION['username']}");
}

try{
    eraseUserPicture($_GET['username']);

    header("Location: profile.php?username={$_GET['username']}");
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 500 Internal Server Error", true, 500);
}
