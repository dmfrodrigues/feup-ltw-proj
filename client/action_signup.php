<?php
session_start();

include_once('../server/connection.php');
include_once('../server/users.php');

if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    die(header('Location: signup.php?failed=1'));
}

try{
    addUser($_POST['username'], $_POST['pwd'], $_POST['name']);
    $_SESSION['username'] = $_POST['username'];
    header('Location: profile.php?username='.$_SESSION['username']);
} catch(PDOException $e) {
    header('Location: signup.php?failed=1');
}

die();
