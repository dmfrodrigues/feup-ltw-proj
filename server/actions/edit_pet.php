<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/shelters.php';
$pet = getPet($_GET['id']);

$N = intval($_POST['photo-number']);
$pictures = [];
for($i = 0; $i < $N; ++$i){
    $picture = [
        'old' => $_POST ["old-$i"],
        'new' => (isset($_FILES["new-$i"]) ? $_FILES["new-$i"] : null)
    ];
    $pictures[] = $picture;
}

$canEdit = true;

if (isset($_SESSION['username'])){

    if(!isset($_SESSION['isShelter']) && $_SESSION['username'] != $pet['postedBy']) $canEdit = false;
    else if (isset($_SESSION['isShelter'])) {
        $shelter = getShelter($_SESSION['isShelter']);
        if (getPetShelter($_GET['id']) !== $shelter['username']) $canEdit = false;
    }

    if ($canEdit) {
        editPet(
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
    }

    
}

if ($canEdit)
    header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id={$_GET['id']}");
else
    header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id={$_GET['id']}'&failed=1");

die();
