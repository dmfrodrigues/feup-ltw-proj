<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/Shelter.php';

$username = $_GET['username'];

if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])){
    addShelterInvitation($_POST['description'], $username, $_SESSION['username']);

    addNotification($username, "shelterInvitation", "The shelter " . $_SESSION['username'] . " invited you to be a collaborator.");

    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username=$username");
}

die();