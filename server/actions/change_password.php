<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
$user = User::fromDatabase($_GET['username']);

if (isset($_SESSION['username'])) {
    editUserPassword(
        $user->getUsername(),
        $_POST['pwd']
    );
    header('Location: ' . PROTOCOL_CLIENT_URL . '/profile.php?username='.$_GET['username']);
}

die();