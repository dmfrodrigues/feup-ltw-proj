<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
$pet = getPet($_GET['id']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $pet['postedBy']){
        header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id={$_GET['id']}'&failed=1");
        die();
    }

    deleteAllPetCommentPhotos($_GET['id']);

    removePet($_GET['id']);
}

header("Location: " . PROTOCOL_CLIENT_URL . "/pets.php");

die();
