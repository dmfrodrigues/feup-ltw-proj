<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
$comment = getPetComment($_POST['id']);

if (isset($_SESSION['username']) && $_SESSION['username'] === $comment['user']){
    deletePetComment($_POST['id']);
}

header("Location: {$_SERVER['HTTP_REFERER']}");

die();
