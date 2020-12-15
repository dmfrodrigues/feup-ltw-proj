<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR.'/Shelter.php';

$user = User::fromDatabase($_GET['username']);

if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])){
    addShelterInvitation($_POST['description'], $user->getUsername(), $_SESSION['username']);

    $shelterLink = "<a href='" . PROTOCOL_API_URL . '/user/' . $_SESSION['username'] . "'>" . $_SESSION['username'] . "</a>";

    addNotification($user, "shelterInvitation", "The shelter " . $shelterLink . " invited you to be a collaborator.");

    header("Location: " . PROTOCOL_API_URL . "/user/{$user->getUsername()}");
}

die();
