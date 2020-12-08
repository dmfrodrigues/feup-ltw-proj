<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/shelters.php';

$username = $_GET['username'];

if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])){
    addShelterInvitation($_POST['description'], $username, $_SESSION['username']);
    header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username=$username");
}

die();