<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR.'/notifications.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/shelters.php';

include_once('templates/common/header.php');

if(isShelter($_GET['username'])) {
    if(isset($_SESSION['username'])) {

        $shelter = getShelter($_GET['username']);
        $user = getUser($_SESSION['username']);


        if (isset($_SESSION['isShelter']) && $_SESSION['username'] === $_GET['username']) {
            include_once('templates/users/edit_profile.php');
            editProfile(true); // true -> is shelter
        }
            
        $userShelter = getUserShelter($user['username']);
        if ($userShelter === $shelter['username']) {
            include_once('templates/users/edit_profile.php');
            editProfile(true); // true -> is shelter
        }

    }
        
}

else if(isset($_SESSION['username']) && $_SESSION['username'] === $_GET['username']) {
    $user = getUser($_GET['username']);
    include_once('templates/users/edit_profile.php');
    editProfile(false); // false -> is not shelter
}
    
include_once('templates/common/footer.php');