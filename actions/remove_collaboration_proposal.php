<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$shelter = $_SESSION['username'];

if (isset($_SESSION['isShelter']) && isset($shelter)) {
    deleteShelterInvitation($_GET['username'], $shelter);
    header("Location: " . PROTOCOL_API_URL."/user/" . $shelter);
}

die();