<?php
    session_start();
    include_once('../server/connection.php');
    include_once('../server/users.php');

    if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
        deleteUser($_SESSION['username']);
        session_destroy();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
    else 
        header('Location: profile.php?username='.$_GET['username'].'&failed=1');
    
?>