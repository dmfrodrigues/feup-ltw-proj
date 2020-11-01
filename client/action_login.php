<?php
session_start();

include_once('../server/connection.php');
include_once('../server/users.php');

if (userExists($_POST['username'], $_POST['password'])){
    $_SESSION['username'] = $_POST['username'];
    header('Location: index.php');
} else {
    header('Location: login.php?failed=1');
}

die();
