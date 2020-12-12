<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/users.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/shelters.php';
$pet = Pet::fromDatabase($_GET['id']);

$N = intval($_POST['photo-number']);
$pictures = [];
for($i = 0; $i < $N; ++$i){
    $picture = [
        'old' => $_POST ["old-$i"],
        'new' => (isset($_FILES["new-$i"]) ? $_FILES["new-$i"]['tmp_name'] : null)
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

        $pet = Pet::fromDatabase($_GET['id']);
        $userWhoPostedPet = $pet->getPostedBy();
        $usersWhoFavoritePet = getUsersWhoFavoritePet($_GET['id']);
        foreach($usersWhoFavoritePet as $userWhoFavoritePet) {
            if ($userWhoFavoritePet['username'] !== $_SESSION['username']) {
                addNotification($userWhoFavoritePet['username'], "favoriteEdited", "Your favorite pet " . $pet->getName() . ", posted by " . $userWhoPostedPet->getUsername() . " was edited by " . $_SESSION['username'] . ".");
            }
        }

        header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id={$_GET['id']}");
        exit();
    }

}

header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id={$_GET['id']}'&failed=1");
die();
