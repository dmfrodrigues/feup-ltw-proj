<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
$user = User::fromDatabase($_GET['username']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $user->getUsername()){
        header('Location: ' . PROTOCOL_CLIENT_URL . '/profile.php?username='.$_GET['username'].'&failed=1');
        die();
    }

    if(!preg_match('/^(?=.*[!@#$%^&*)(+=._-])(?=.*[A-Z])(?=.{7,}).*$/', $_POST['pwd'])) {
        header('Location: ' . PROTOCOL_CLIENT_URL . '/change_password.php?username=' . $_GET['username'] .'&failed=1&errorCode=5');
        die();
    }

    editUserPassword(
        $user->getUsername(),
        $_POST['pwd']
    );
    header('Location: ' . PROTOCOL_CLIENT_URL . '/profile.php?username='.$_GET['username']);
}

die();