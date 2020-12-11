<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR . '/users.php';
$user = User::fromDatabase($_GET['username']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $user["username"]){
        header('Location: ' . PROTOCOL_CLIENT_URL . '/profile.php?username='.$_GET['username'].'&failed=1');
        die();
    }

    editUserPassword(
        $user["username"],
        $_POST['pwd']
    );
    header('Location: ' . PROTOCOL_CLIENT_URL . '/profile.php?username='.$_GET['username']);
}

die();