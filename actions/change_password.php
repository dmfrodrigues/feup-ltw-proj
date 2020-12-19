<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';

$user = User::fromDatabase($_GET['username']);

if (isset($_SESSION['username'])) {
    try {
        editUserPassword(
            $user->getUsername(),
            $_POST['pwd']
        );
        header('Location: ' . PROTOCOL_SERVER_URL . '/user/'.$user->getUsername());
        exit();
    } catch(Exception $e) {
    header('Location: ' . PROTOCOL_SERVER_URL . '/user/' . $_SESSION['username'] .'/password/change?failed=1&errorCode=5');
}
    
} else { my_response_code(403); die(); }
