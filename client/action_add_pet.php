<?php
session_start();

include_once('../server/connection.php');
include_once('../server/pets.php');

var_dump($_POST);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $_POST["postedBy"]){
        echo "Error";
        die();
    }

    $petId = addPet(
        $_POST["name"],
        $_POST["species"],
        $_POST["age"],
        $_POST["sex"],
        $_POST["size"],
        $_POST["color"],
        $_POST["location"],
        $_POST["description"],
        $_POST["postedBy"]
    );
    header('Location: pet.php?id='.$petId);
}

die();
