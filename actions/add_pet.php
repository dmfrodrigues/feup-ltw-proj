<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Pet.php';

$files = [];

foreach($_FILES as $key => $value){
    $id = intval(explode('-', $key)[2]);
    $files[$id] = $value;
}
ksort($files);

$tmpFilePaths = array_map(function($file) : string { return $file['tmp_name']; }, $files);

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
        $tmpFilePaths
    );
    header("Location: " . PROTOCOL_API_URL . "/pet/$petId");
}

die();
