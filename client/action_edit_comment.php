<?php
session_start();

include_once __DIR__ . '/../server/server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR . '/pets.php';

$oldComment = getPetComment($_POST['commentId']);

if ($oldComment['user'] != $_SESSION['username']) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

$file = $_FILES['picture'];

try {
    editPetComment(
        $_POST['commentId'],
        $_POST['text'],
        $_POST['deleteFile'],
        $file
    );

    header("Location: " . $_SERVER['HTTP_REFERER']);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 500 Internal Server Error", true, 500);
}
