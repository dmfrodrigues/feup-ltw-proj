<?php
session_start();

include_once __DIR__.'/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';

if (userExists($_POST['username'], $_POST['password'])){
    $_SESSION['username'] = $_POST['username'];
    header('Location: index.php');
} else {
    header('Location: login.php?failed=1');
}

die();
