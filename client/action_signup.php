<?php
session_start();

$username = $_POST['username'];
$password = $_POST['pwd'];
$rpt_password = $_POST['rpt_pwd'];

if (strcmp($password, $rpt_password) != 0) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => "Password don't match");
    die(header('Location: ../signup.php'));
}


if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    die(header('Location: ../signup.php'));
}

// TODO insert user in database
die(header('Location: ../signup.php'));
