<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/errors/errors.php';

$shelter = Shelter::fromDatabase($_GET['shelter']);

if (isset($_SESSION['username']) && !isset($_SESSION['isShelter'])) {
    $userShelter = User::fromDatabase($_SESSION['username'])->getShelter();
    if ($shelter->getUsername() === $userShelter->getUsername()) {
        leaveShelter($_SESSION['username']);

        $userLink = "<a href='" . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . "'>" . $_SESSION['username'] . "</a>";

        addNotification($shelter, "userLeftShelter", "The user " . $userLink . " left the shelter.");

        header("Location: " . PROTOCOL_API_URL."/user/" . $_SESSION['username']); 
        die();
    }
}

header("Location: " . PROTOCOL_API_URL);

die();