<?php

include_once("../server/users.php");

if($_GET['username'] != $_SESSION['username']){
    header('Location: profile.php?username='.$_SESSION['username']);
}

$file = $_FILES['profile_picture'];

try{
    saveUserPicture($_GET['username'], $file);

    header("Location: profile.php?username=".$_GET['username']);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', true, 400);
}
