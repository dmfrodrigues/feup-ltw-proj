<?php
set_error_handler(function($errno, $errstr, $errfile, $errline ){
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
try {
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/users.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/shelters.php';
require_once SERVER_DIR.'/notifications.php';

$title = $_GET['username'];

require_once 'templates/common/header.php';
if(isShelter($_GET['username'])) {
    $shelter = Shelter::fromDatabase($_GET['username']);
    $added_pets = $shelter->getPetsForAdoption();
    $collaborators = $shelter->getCollaborators();

    if(isset($_SESSION['username']) && isset($_SESSION['isShelter']) && $_SESSION['username'] == $_GET['username'])
        require_once 'templates/shelters/profile_shelter_me.php';
    else
        require_once 'templates/shelters/profile_shelter_others.php';
} else {
    $user = User::fromDatabase($_GET['username']);
    if(!is_null($user)){
        $added_pets = $user->getPetsNotAdopted();
        $favorite_pets = $user->getFavoritePets();
    }
    else {header( "Location: error.php" );die();}

    if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
        require_once 'templates/users/profile_me.php';
    } else
        require_once 'templates/users/profile_others.php';
}
require_once 'templates/common/footer.php';
}
catch (Exception $e) {
    header( "Location: error.php" );die();
}
