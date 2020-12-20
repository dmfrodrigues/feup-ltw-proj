<?php

// session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/errors/errors.php';

$shelter = Shelter::fromDatabase($_GET['shelter']);

if (isset($_SESSION['username']) && !isset($_SESSION['isShelter'])) {
    $userShelter = User::fromDatabase($_SESSION['username'])->getShelter();
    if ($shelter->getUsername() === $userShelter->getUsername()) {
        leaveShelter($_SESSION['username']);

        $userLink = "<a href='user/{$_SESSION['username']}'>{$_SESSION['username']}</a>";

        addNotification($shelter, "userLeftShelter", "The user $userLink left the shelter.");

        header_location("/user/" . $_SESSION['username']); 
        die();
    }
}

header_location('');

die();