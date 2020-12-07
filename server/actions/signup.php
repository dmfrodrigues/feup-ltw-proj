<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';

if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    header('Location: ' . PROTOCOL_CLIENT_URL . '/signup.php?failed=1');
    die();
}

try{
    addUser($_POST['username'], $_POST['pwd'], $_POST['name']);
    $_SESSION['username'] = $_POST['username'];
    header('Location: ' . PROTOCOL_CLIENT_URL . '/profile.php?username='.$_SESSION['username']);
} catch(PDOException $e) {
    $errorMessage = urlencode('Something Went Wrong');
    header('Location: ' . PROTOCOL_CLIENT_URL . '/signup.php?failed=1&errorMessage=' . $errorMessage);
} catch(Exception $e) {
    $errorMessage = urlencode($e->getMessage());
    header('Location: ' . PROTOCOL_CLIENT_URL . '/signup.php?failed=1&errorMessage=' . $errorMessage);
}
die();
