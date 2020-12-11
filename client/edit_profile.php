<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/users.php';
require_once SERVER_DIR . '/shelters.php';

require_once('templates/common/header.php');

if(isShelter($_GET['username'])) {
    if(isset($_SESSION['username'])) {

        $shelter = getShelter($_GET['username']);
        $user = User::fromDatabase($_SESSION['username']);


        if (isset($_SESSION['isShelter']) && $_SESSION['username'] === $_GET['username']) {
            require_once('templates/users/edit_profile.php');
            editProfile(true); // true -> is shelter
        }
            
        $userShelter = getUserShelter($user->getUsername());
        if ($userShelter === $shelter['username']) {
            require_once('templates/users/edit_profile.php');
            editProfile(true); // true -> is shelter
        }

    }
        
}

else if(isset($_SESSION['username']) && $_SESSION['username'] === $_GET['username']) {
    $user = User::fromDatabase($_GET['username']);
    require_once('templates/users/edit_profile.php');
    editProfile(false); // false -> is not shelter
}
    
require_once('templates/common/footer.php');