<?php
session_start();

include_once('../server/connection.php');
include_once('../server/users.php');
$user = getUser($_GET['username']);

if (isset($_SESSION['username'])){
    echo "Yes";
    if($_SESSION['username'] != $user["username"]){
        header('Location: profile.php?username='.$_GET['username'].'&failed=1');
        die();
    }

    editUser(
        $_POST["username"],
        $_POST["name"]
    );

    header('Location: profile.php?username='.$_GET['username']);
}

die();

