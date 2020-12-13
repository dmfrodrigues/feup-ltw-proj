<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
$user = User::fromDatabase($_GET['username']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $user->getUsername()){
        header('Location: ' . PROTOCOL_API_URL . '/user/'.$_GET['username'].'&failed=1');
        die();
    }

    editUserPassword(
        $user->getUsername(),
        $_POST['pwd']
    );
    header('Location: ' . PROTOCOL_API_URL . '/user/'.$_GET['username']);
}

die();