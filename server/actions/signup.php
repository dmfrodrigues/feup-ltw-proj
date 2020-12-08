<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';

if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    header('Location: ' . CLIENT_URL . '/signup.php?failed=1');
    die();
}

try{
    addUser($_POST['username'], $_POST['pwd'], $_POST['name']);
    $_SESSION['username'] = $_POST['username'];
    header('Location: ' . CLIENT_URL . '/profile.php?username='.$_SESSION['username']);
} catch(PDOException $e) {
    // $errorMessage = urlencode('Something Went Wrong');
    header('Location: ' . CLIENT_URL . '/signup.php?failed=1&errorCode=-1');
} catch(UserAlreadyExistsException $e) {
    header('Location: ' . CLIENT_URL . '/signup.php?failed=1&errorCode=2');
} catch(Exception $e) {
    $errorMessage = urlencode($e->getMessage());
    header('Location: ' . CLIENT_URL . '/signup.php?failed=1&errorCode=' . $errorMessage);
}
die();
