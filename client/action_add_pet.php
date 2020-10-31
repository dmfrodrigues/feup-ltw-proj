<?php
session_start();

include_once('../server/connection.php');
include_once('../server/pets.php');

if (isset($_SESSION['username'])){
    $petId = addPet(
        $_POST["name"],
        $_POST["species"],
        $_POST["age"],
        $_POST["sex"],
        $_POST["size"],
        $_POST["color"],
        $_POST["location"],
        $_POST["description"],
        $_SESSION["username"]
    );
    header('Location: pet.php?id='.$petId);
}

die();
