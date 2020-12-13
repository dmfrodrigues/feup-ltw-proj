<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/Shelter.php';

$failed = true;
$usernameChanged = false;

if(isShelter($user->getUsername())) {
    if(isset($_SESSION['username'])) {

        $shelter = Shelter::fromDatabase($user->getUsername());

        if (isset($_SESSION['isShelter']) && $_SESSION['username'] === $user->getUsername()) {
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

    if(isset($_SESSION['username']) && $_SESSION['username'] === $user->getUsername()) {
        
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
        header("Location: " . PROTOCOL_API_URL . "/user/{$user->getUsername()}");
    
} 
else
    header("Location: " . PROTOCOL_API_URL . "/user/{$user->getUsername()}&failed=1");

die();