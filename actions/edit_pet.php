<?php

require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/Shelter.php';

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
                $user = User::fromDatabase($userWhoFavoritePet['username']);

                $petNameLink = "<a href='pet/{$pet->getId()}'>{$pet->getName()}</a>";
                $userWhoPostedPetLink = "<a href='user/{$userWhoPostedPet->getUsername()}'>{$userWhoPostedPet->getUsername()}</a>";
                $userLink = "<a href='user/{$_SESSION['username']}'>{$_SESSION['username']}</a>";

                addNotification($user, "favoriteEdited", "Your favorite pet $petNameLink, posted by $userWhoPostedPetLink was edited by $userLink.");
            }
        }

        header_location("/pet/{$_GET['id']}");
        exit();
    }

}

header_location("/pet/{$_GET['id']}&failed=1");
die();
