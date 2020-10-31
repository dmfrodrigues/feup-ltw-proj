<?php
session_start();
include_once('../server/connection.php');
include_once('../server/users.php');
if (userExists($_POST['username'], $_POST['pwd']))
    $_SESSION['username'] = $_POST['username'];
header('Location: ' . $_SERVER['HTTP_REFERER']);
die();
?>