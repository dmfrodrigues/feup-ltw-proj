<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/pets.php';

$files = [];

foreach($_FILES as $key => $value){
    $id = intval(explode('-', $key)[2]);
    $files[$id] = $value;
}
ksort($files);

if (isset($_SESSION['username'])){
    $petId = addPet(
        $_POST['name'],
        $_POST['species'],
        $_POST['age'],
        $_POST['sex'],
        $_POST['size'],
        $_POST['color'],
        $_POST['location'],
        $_POST['description'],
        $_SESSION['username'],
        $files
    );
    header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id=$petId");
}

die();
