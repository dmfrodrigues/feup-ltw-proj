<?php

require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$user = User::fromDatabase($_GET['username']);

if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])){
    addShelterInvitation($_POST['description'], $user->getUsername(), $_SESSION['username']);

    $shelterLink = "<a href='user/{$_SESSION['username']}'>{$_SESSION['username']}</a>";

    addNotification($user, "shelterInvitation", "The shelter $shelterLink invited you to be a collaborator.");

    header_location("/user/{$user->getUsername()}");
}

die();
