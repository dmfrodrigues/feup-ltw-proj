<?php
session_start();

include_once __DIR__ . '/../server/server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR . '/pets.php';

addPetComment(
    $_POST['petId'],
    $_POST['username'],
    ($_POST['answerTo'] === '' ? null : intval($_POST['answerTo'])),
    $_POST['text'],
    []
);

header("Location: ".$_SERVER['HTTP_REFERER']);
