<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/users.php';
require_once SERVER_DIR . '/pets.php';

if(isset($_SESSION['username'])) 
    $previouslyOwnedPets = getAdoptedPetsPublishedByUser($_SESSION['username']);

require_once 'templates/common/header.php';
require_once 'templates/pets/view_previously_owned_pets.php';
require_once 'templates/common/footer.php';
