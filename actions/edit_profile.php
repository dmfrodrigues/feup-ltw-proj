<?php

require_once SERVER_DIR . '/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';
require_once SERVER_DIR . '/classes/Shelter.php';

$failed = true;
$usernameChanged = false;

$user = User::fromDatabase($_GET['username']);

$shelterId = null;

if(isShelter($user->getUsername())) {
    if(isset($_SESSION['username'])) {

        $shelter = Shelter::fromDatabase($user->getUsername());

        if (isset($_SESSION['isShelter']) && $_SESSION['username'] === $user->getUsername()) {
            try {
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
            } catch(UserAlreadyExistsException $e) {
                header_location('/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=2');
                die();
            } catch(InvalidUsernameException $e) {
                header_location('/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=6');
                die();
            } catch(Exception $e) {
                header_location('/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=5');
                die();
            }
            
        }
            
        $user = User::fromDatabase($_SESSION['username']);

        $userShelter = User::fromDatabase($user->getUsername())->getShelterId();
        if ($userShelter === $shelter->getUsername()) { // if who is editing is not the shelter itself, the username cannot be changed
            try {
                updateShelterInfo(
                    $shelter->getUsername(),
                    $shelter->getUsername(),
                    $_POST['name'],
                    $_POST['location'],
                    $_POST['description']
                );
                $failed = false;
                $shelterId = $shelter->getUsername();
            } catch(UserAlreadyExistsException $e) {
                header_location('/user/' . $userShelter . '/edit?failed=1&errorCode=2');
                die();
            } catch(InvalidUsernameException $e) {
                header_location('/user/' . $userShelter . '/edit?failed=1&errorCode=6');
                die();
            } catch(Exception $e) {
                header_location('/user/' . $userShelter . '/edit?failed=1&errorCode=5');
                die();
            }
            
        }

    }
}
else {

    if(isset($_SESSION['username']) && $_SESSION['username'] === $user->getUsername()) {
        
        try {
            editUser(
                $user->getUsername(),
                $_POST['username'],
                $_POST['name']
            );
            $_SESSION['username'] = $_POST['username'];
            $usernameChanged = true;
            $failed = false;
        } catch(UserAlreadyExistsException $e) {
                header_location('/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=2');
                die();
        } catch(InvalidUsernameException $e) {
            header_location('/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=6');
            die();
        } catch(Exception $e) {
            header_location('/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=5');
            die();
        }
        
    }
}

if (!$failed) {

    if ($shelterId !== null)
        header_location("/user/{$shelterId}");
    else if ($usernameChanged)
        header_location("/user/{$_POST['username']}");
    else
        header_location("/user/{$user->getUsername()}");
} 

die();