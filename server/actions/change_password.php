<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR . '/users.php';
$user = getUser($_GET['username']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $user["username"]){
        header('Location: ' . CLIENT_URL . '/profile.php?username='.$_GET['username'].'&failed=1');
        die();
    }

    editUserPassword(
        $user["username"],
        $_POST['pwd']
    );
    header('Location: ' . CLIENT_URL . '/profile.php?username='.$_GET['username']);
}

die();