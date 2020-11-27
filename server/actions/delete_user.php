<?php
    session_start();

    include_once __DIR__ . '/../server.php';
    include_once SERVER_DIR . '/connection.php';
    include_once SERVER_DIR . '/users.php';

    if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
        deleteUser($_SESSION['username']);
        session_destroy();
        header('Location: ' . CLIENT_URL . '/index.php');
        die();
    }
    else 
        header('Location: ' . CLIENT_URL . '/profile.php?username='.$_GET['username'].'&failed=1');
