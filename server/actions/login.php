<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';

if (userPasswordExists($_POST['username'], $_POST['password'])){
    $_SESSION['username'] = $_POST['username'];
    header('Location: ' . CLIENT_URL . '/index.php');
} else {
    header('Location: ' . CLIENT_URL . '/login.php?failed=1');
}

die();
