<?php
session_start();

include_once('../server/connection.php');
include_once('../server/pets.php');
$pet = getPet($_GET['id']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $pet["postedBy"]){
        echo "Error";
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
    header('Location: pet.php?id='.$_GET['id']);
}

die();