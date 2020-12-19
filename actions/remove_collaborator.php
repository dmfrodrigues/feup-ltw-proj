<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Shelter.php';

if (isset($_SESSION['isShelter']) && isset($_SESSION['username']) ) {
    leaveShelter($user->getId());
    header("Location: " . PROTOCOL_SERVER_URL."/user/" . $_SESSION['username']);
}

die();