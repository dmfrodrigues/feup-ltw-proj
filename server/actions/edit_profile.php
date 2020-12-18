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
                header('Location: ' . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=2');
                die();
            } catch(InvalidUsernameException $e) {
                header('Location: ' . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=6');
                die();
            } catch(Exception $e) {
                header('Location: ' . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=5');
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
                header('Location: ' . PROTOCOL_API_URL . '/user/' . $userShelter . '/edit?failed=1&errorCode=2');
                die();
            } catch(InvalidUsernameException $e) {
                header('Location: ' . PROTOCOL_API_URL . '/user/' . $userShelter . '/edit?failed=1&errorCode=6');
                die();
            } catch(Exception $e) {
                header('Location: ' . PROTOCOL_API_URL . '/user/' . $userShelter . '/edit?failed=1&errorCode=5');
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
                header('Location: ' . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=2');
                die();
        } catch(InvalidUsernameException $e) {
            header('Location: ' . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=6');
            die();
        } catch(Exception $e) {
            header('Location: ' . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . '/edit?failed=1&errorCode=5');
            die();
        }
        
    }
}

if (!$failed) {

    if ($shelterId !== null)
        header("Location: " . PROTOCOL_API_URL . "/user/{$shelterId}");
    else if ($usernameChanged)
        header("Location: " . PROTOCOL_API_URL . "/user/{$_POST['username']}");
    else
        header("Location: " . PROTOCOL_API_URL . "/user/{$user->getUsername()}");
} 

die();