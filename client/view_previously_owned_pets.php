<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/pets.php';

if(isset($_SESSION['username'])) 
    $previouslyOwnedPets = getAdoptedPetsPublishedByUser($_SESSION['username']);

include_once 'templates/common/header.php';
include_once 'templates/pets/view_previously_owned_pets.php';
include_once 'templates/common/footer.php';