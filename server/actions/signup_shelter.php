<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/shelters.php';

if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    $errorMessage = urlencode($_SESSION['messages']['content']);
    header('Location: ' . CLIENT_URL . '/signup.php?failed=1&errorMessage=' . $errorMessage);
    die();
}

try {
    addShelter(
        htmlspecialchars($_POST['username']), 
        htmlspecialchars($_POST['shelterName']), 
        htmlspecialchars($_POST['location']), 
        htmlspecialchars($_POST['description']), 
        htmlspecialchars($_POST['pwd'])
    );
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
    $_SESSION['isShelter'] = "true";
    header('Location: ' . CLIENT_URL . '/profile_shelter.php?username='. $_SESSION['username']);
} catch(PDOException $e) {
    $errorMessage = urlencode($e->getMessage());
    header('Location: ' . CLIENT_URL . '/signup.php?failed=1&errorMessage=' . $errorMessage);
} catch(Exception $e) {
    $errorMessage = urlencode($e->getMessage());
    header('Location: ' . CLIENT_URL . '/signup.php?failed=1&errorMessage=' . $errorMessage);
}

die();
