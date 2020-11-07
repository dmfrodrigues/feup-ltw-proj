<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
$pet = getPet($_GET['id']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $pet['postedBy']){
        header("Location: pet.php?id={$_GET['id']}'&failed=1");
        die();
    }

    removePet(
        $_GET['id']
    );
}

header("Location: pets.php");

die();
