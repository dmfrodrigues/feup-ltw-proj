<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/pets.php';
$pet = Pet::fromDatabase($_GET['id']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $pet->getPostedBy(true)){
        header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id={$_GET['id']}'&failed=1");
        die();
    }

    deleteAllPetCommentPhotos($_GET['id']);

    Pet::deleteFromDatabase($_GET['id']);
}

header("Location: " . PROTOCOL_CLIENT_URL . "/pets.php");

die();
