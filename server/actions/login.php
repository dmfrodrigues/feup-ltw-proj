<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';

try {
    if (userPasswordExists($_POST['username'], $_POST['password'])){
        $_SESSION['username'] = $_POST['username'];
        header('Location: ' . PROTOCOL_CLIENT_URL . '/index.php');
    } else if(shelterPasswordExists($_POST['username'], $_POST['password'])){
        $_SESSION['username'] = $_POST['username'];
        header('Location: ' . PROTOCOL_CLIENT_URL . '/index.php');
    } else {
        header('Location: ' . PROTOCOL_CLIENT_URL . '/login.php?failed=1');
    }
} catch(PDOException $e) {
    $errorMessage = urlencode('Something Went Wrong');
    header('Location: ' . PROTOCOL_CLIENT_URL . '/login.php?failed=1&errorMessage=' . $errorMessage);
} catch(Exception $e) {
    $errorMessage = urlencode($e->getMessage());
    header('Location: ' . PROTOCOL_CLIENT_URL . '/login.php?failed=1&errorMessage=' . $errorMessage);
}

die();
