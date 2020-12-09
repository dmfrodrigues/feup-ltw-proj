<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/shelters.php';

$failed = true;

if(isShelter($_GET['username'])) {

    $shelter = getShelter($_GET['username']);

    if(isset($_SESSION['username']) && isset($_SESSION['isShelter']) && $_SESSION['username'] == $_GET['username']) {
        
        updateShelterInfo(
            $shelter['username'],
            $_POST['username'],
            $_POST['name'],
            $_POST['location'],
            $_POST['description']
        );
        $_SESSION['username'] = $_POST['username'];
        $failed = false;
    }
}
else {

    $user = getUser($_GET['username']);

    if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
        
        editUser(
            $user['username'],
            $_POST['username'],
            $_POST['name']
        );
        $_SESSION['username'] = $_POST['username'];
        $failed = false;
    }
}

if (!$failed)
    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_POST['username']}");
else
    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username={$_GET['username']}&failed=1");

die();