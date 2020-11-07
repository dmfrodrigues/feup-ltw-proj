<?php
    session_start();
    include_once('../server/connection.php');
    include_once('../server/users.php');

    if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username']) {
        deleteUser($_SESSION['username']);
        header("Location: index.php");
    }
    else 
        header('Location: profile.php?username='.$_GET['username'].'&failed=1');
    
?>