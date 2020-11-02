<?php
session_start();

include_once __DIR__.'/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
$pet = getPet($_GET['id']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $pet["postedBy"]){
        header('Location: pet.php?id='.$_GET['id'].'&failed=1');
        die();
    }

    editPet(
        $_GET['id'],
        $_POST["name"],
        $_POST["species"],
        $_POST["age"],
        $_POST["sex"],
        $_POST["size"],
        $_POST["color"],
        $_POST["location"],
        $_POST["description"]
    );
}

header('Location: pet.php?id='.$_GET['id']);

die();
