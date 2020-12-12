<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php'
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/Pet.php';

if(isset($_SESSION['username'])){
    $user = User::fromDatabase($_SESSION['username']);
    $previouslyOwnedPets = $user->getPetsAdopted();
    $title = "previously owned by" . $_SESSION['username'];
}

require_once 'templates/common/header.php';
require_once 'templates/pets/view_previously_owned_pets.php';
require_once 'templates/common/footer.php';
