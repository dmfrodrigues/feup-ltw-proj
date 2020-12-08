<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';

try {
    if(userPasswordExists($_POST['username'], $_POST['password'])) {
        if (!isShelter($_POST['username'])){
            $_SESSION['username'] = $_POST['username'];
            header('Location: ' . CLIENT_URL . '/index.php');
        } else {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['isShelter'] = 1;
            header('Location: ' . CLIENT_URL . '/index.php');
        }
    }
    else 
        header('Location: ' . CLIENT_URL . '/login.php?failed=1');
} catch(PDOException $e) {
    $errorMessage = urlencode('Something Went Wrong');
    header('Location: ' . CLIENT_URL . '/login.php?failed=1&errorMessage=' . $errorMessage);
} catch(Exception $e) {
    $errorMessage = urlencode($e->getMessage());
    header('Location: ' . CLIENT_URL . '/login.php?failed=1&errorMessage=' . $errorMessage);
}

die();
