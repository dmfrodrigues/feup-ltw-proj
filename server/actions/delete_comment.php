<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/pets.php';
$comment = getPetComment($_POST['id']);

if (isset($_SESSION['username']) && $_SESSION['username'] === $comment['user']){
    try {
        deletePetComment($_POST['id']);
    }
    catch(Exception $e) { }
}

header("Location: ". $_SERVER['HTTP_REFERER']);

die();
