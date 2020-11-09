<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';


if ($_GET['username'] != $_SESSION['username']) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}


changeAdoptionRequestOutcome($_GET['requestId'], $_GET['outcome']);
header("Location: profile.php?username=" . $_SESSION['username']);