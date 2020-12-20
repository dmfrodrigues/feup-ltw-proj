<?php

// session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';

$user = User::fromDatabase($_GET['username']);

if(isset($_SESSION['username']) && $_SESSION['username'] == $user->getUsername()) {
    User::deleteFromDatabase($user->getUsername());
    session_destroy();
    header_location('');
    die();
}
else 
    header_location('/user/'.$user->getUsername().'&failed=1');
