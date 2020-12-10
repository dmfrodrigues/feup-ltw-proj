<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/users.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/shelters.php';
require_once SERVER_DIR.'/notifications.php';

require_once 'templates/common/header.php';
if(isShelter($_GET['username'])) {
    $shelter = getShelter($_GET['username']);
    $added_pets = getShelterPetsForAdoption($_GET['username']);
    $collaborators = getShelterCollaborators($_GET['username']);

    if(isset($_SESSION['username']) && isset($_SESSION['isShelter']) && $_SESSION['username'] == $_GET['username'])
        require_once 'templates/shelters/profile_shelter_me.php';
    else
        require_once 'templates/shelters/profile_shelter_others.php';
}
else {
    $user = getUser($_GET['username']);
    $added_pets = getAddedPetsNotAdopted($_GET['username']);
    $favorite_pets = getFavoritePets($_GET['username']);

    if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
        require_once 'templates/users/profile_me.php';
    } else
        require_once 'templates/users/profile_others.php';
}
require_once 'templates/common/footer.php';