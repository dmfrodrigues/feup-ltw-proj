<?php
    
    require_once __DIR__ . '/../server.php';
    require_once SERVER_DIR . '/connection.php';
    require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';

    if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
        User::deleteFromDatabase($_SESSION['username']);
        session_destroy();
        header('Location: ' . PROTOCOL_API_URL);
        die();
    }
    else 
        header('Location: ' . PROTOCOL_API_URL . '/user/'.$_GET['username'].'&failed=1');
