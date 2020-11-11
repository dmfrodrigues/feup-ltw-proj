<?php
session_start();

include_once __DIR__ . '/server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR . '/users.php';
$user = getUser($_GET['username']);

if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    die(header("Location: edit_profile.php?username={$_GET['username']}&failed=1"));
}

if (isset($_SESSION['username'])){

    if($_SESSION['username'] != $user['username']){
        header("Location: profile.php?username={$_GET['username']}&failed=1");
        die();
    }

    editUser(
        $user['username'],
        $_POST['username'],
        $_POST['name']
    );

    $_SESSION['username'] = $_POST['username'];

    header("Location: profile.php?username={$_POST['username']}");
}

die();

