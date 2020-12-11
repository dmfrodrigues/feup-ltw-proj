<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR . '/users.php';
require_once SERVER_DIR . '/shelters.php';

$failed = true;
$usernameChanged = false;

if(isShelter($_GET['username'])) {
    if(isset($_SESSION['username'])) {

        $shelter = getShelter($_GET['username']);

        if (isset($_SESSION['isShelter']) && $_SESSION['username'] === $_GET['username']) {
            updateShelterInfo(
                $shelter['username'],
                $_POST['username'],
                $_POST['name'],
                $_POST['location'],
                $_POST['description']
            );
            $_SESSION['username'] = $_POST['username'];
            $usernameChanged = true;
            $failed = false;
        }
            
        $user = getUser($_SESSION['username']);

        $userShelter = getUserShelter($user['username']);
        if ($userShelter === $shelter['username']) { // if who is editing is not the shelter itself, the username cannot be changed
            updateShelterInfo(
                $shelter['username'],
                $shelter['username'],
                $_POST['name'],
                $_POST['location'],
                $_POST['description']
            );
            $failed = false;
        }

    }
}
else {

    $user = getUser($_GET['username']);

    if(isset($_SESSION['username']) && $_SESSION['username'] === $_GET['username']) {
        
        editUser(
            $user['username'],
            $_POST['username'],
            $_POST['name']
        );
        $_SESSION['username'] = $_POST['username'];
        $usernameChanged = true;
        $failed = false;
    }
}

if (!$failed) {
    if ($usernameChanged)
        header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_POST['username']}");
    else
        header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_GET['username']}");
    
} 
else
    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_GET['username']}&failed=1");

die();