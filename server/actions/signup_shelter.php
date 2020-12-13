<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
require_once SERVER_DIR.'/Shelter.php';

try {
    addShelter(
        htmlspecialchars($_POST['username']), 
        htmlspecialchars($_POST['shelterName']), 
        htmlspecialchars($_POST['location']), 
        htmlspecialchars($_POST['description']), 
        htmlspecialchars($_POST['pwd'])
    );
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
    $_SESSION['isShelter'] = 1;
    header('Location: ' . PROTOCOL_CLIENT_URL . '/profile.php?username='. $_SESSION['username']);
} catch(PDOException $e) {
    header('Location: ' . PROTOCOL_CLIENT_URL . '/signup.php?failed=1&errorCode=-1');
} catch(UserAlreadyExistsException $e) {
    header('Location: ' . PROTOCOL_CLIENT_URL . '/signup.php?failed=1&errorCode=2');
} catch(Exception $e) {
    header('Location: ' . PROTOCOL_CLIENT_URL . '/signup.php?failed=1&errorCode=');
}

die();
