<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/shelters.php';
$pet = Pet::fromDatabase($_GET['id']);

$N = intval($_POST['photo-number']);
$pictures = [];
for($i = 0; $i < $N; ++$i){
    $picture = [
        'old' => $_POST ["old-$i"],
        'new' => (isset($_FILES["new-$i"]) ? $_FILES["new-$i"] : null)
    ];
    $pictures[] = $picture;
}

if (isset($_SESSION['username'])){

    if (userCanEditPet($_SESSION['username'], intval($_GET['id']))) {
        Pet::edit(
            $_GET['id'],
            $_POST['name'],
            $_POST['species'],
            $_POST['age'],
            $_POST['sex'],
            $_POST['size'],
            $_POST['color'],
            $_POST['location'],
            $_POST['description'],
            $pictures
        );
        header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id={$_GET['id']}");
        die();
    }

}

header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id={$_GET['id']}'&failed=1");
die();
