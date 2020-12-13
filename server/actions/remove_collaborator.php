<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Pet.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';

session_start();

$user = $_GET['username'];

if (isset($_SESSION['isShelter']) && isset($_SESSION['username']) ) {
    leaveShelter($user);
    header("Location: " . PROTOCOL_API_URL."/user/" . $_SESSION['username']);
}

die();