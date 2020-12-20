<?php

require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$shelter = $_SESSION['username'];
$user = User::fromDatabase($_GET['username']);

if (isset($shelter) && isset($_SESSION['isShelter'])) {
    deleteShelterInvitation($user->getUsername(), $shelter);
    header_location("/user/" . $shelter);
}

die();