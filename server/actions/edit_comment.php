<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR . '/Pet.php';

$oldComment = Comment::fromDatabase(intval($_POST['commentId']));

if($oldComment == null){ http_response_code(400); die(); }
if ($oldComment->getUserId() != $_SESSION['username']) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die();
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
