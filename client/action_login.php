<?php
session_start();

include_once('../server/connection.php');
include_once('../server/users.php');

$ret = userExists($_POST['username'], $_POST['password']);

if ($ret){
    $_SESSION['username'] = $_POST['username'];
    header('Location: index.php');
} else {
    header('Location: login.php?failed=1');
}

die();
