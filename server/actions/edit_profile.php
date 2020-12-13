<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/Shelter.php';

session_start();

$failed = true;
$usernameChanged = false;

if(isShelter($_GET['username'])) {
    if(isset($_SESSION['username'])) {

        $shelter = Shelter::fromDatabase($_GET['username']);

        if (isset($_SESSION['isShelter']) && $_SESSION['username'] === $_GET['username']) {
            updateShelterInfo(
                $shelter->getUsername(),
                $_POST['username'],
                $_POST['name'],
                $_POST['location'],
                $_POST['description']
            );
            $_SESSION['username'] = $_POST['username'];
            $usernameChanged = true;
            $failed = false;
        }
            
        $user = User::fromDatabase($_SESSION['username']);

        $userShelter = User::fromDatabase($user->getUsername())->getShelterId();
        if ($userShelter === $shelter->getUsername()) { // if who is editing is not the shelter itself, the username cannot be changed
            updateShelterInfo(
                $shelter->getUsername(),
                $shelter->getUsername(),
                $_POST['name'],
                $_POST['location'],
                $_POST['description']
            );
            $failed = false;
        }

    }
}
else {

    $user = User::fromDatabase($_GET['username']);

    if(isset($_SESSION['username']) && $_SESSION['username'] === $_GET['username']) {
        
        editUser(
            $user->getUsername(),
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
        header("Location: " . PROTOCOL_API_URL . "/user/{$_POST['username']}");
    else
        header("Location: " . PROTOCOL_API_URL . "/user/{$_GET['username']}");
    
} 
else
    header("Location: " . PROTOCOL_API_URL . "/user/{$_GET['username']}&failed=1");

die();