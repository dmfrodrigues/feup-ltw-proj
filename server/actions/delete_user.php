<?php
    session_start();

    require_once __DIR__ . '/../server.php';
    require_once SERVER_DIR . '/connection.php';
    require_once SERVER_DIR . '/User.php'
require_once SERVER_DIR . '/Shelter.php';

    if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
        User::deleteFromDatabase($_SESSION['username']);
        session_destroy();
        header('Location: ' . PROTOCOL_CLIENT_URL . '/index.php');
        die();
    }
    else 
        header('Location: ' . PROTOCOL_CLIENT_URL . '/profile.php?username='.$_GET['username'].'&failed=1');
