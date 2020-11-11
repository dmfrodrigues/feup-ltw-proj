<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR . '/pets.php';

if ($_POST['username'] != $_SESSION['username']) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

$file = $_FILES['picture'];

try {
    addPetComment(
        $_POST['petId'],
        $_POST['username'],
        ($_POST['answerTo'] === '' ? null : intval($_POST['answerTo'])),
        $_POST['text'],
        $file
    );

    header("Location: " . $_SERVER['HTTP_REFERER']);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header("{$_SERVER['SERVER_PROTOCOL']} 500 Internal Server Error", true, 500);
}
