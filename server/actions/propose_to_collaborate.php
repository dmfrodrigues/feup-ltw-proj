<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Shelter.php';

session_start();

$username = $_GET['username'];

if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])){
    addShelterInvitation($_POST['description'], $username, $_SESSION['username']);

    addNotification($username, "shelterInvitation", "The shelter " . $_SESSION['username'] . " invited you to be a collaborator.");

    header("Location: " . PROTOCOL_API_URL . "/user/$username");
}

die();