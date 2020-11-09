<?php
session_start();

include_once('../server/connection.php');
include_once('../server/users.php');

if ($_GET['username'] != $_SESSION['username']) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}


changeAdoptionRequestOutcome($_GET['requestId'], $_GET['outcome']);
header("Location: profile.php?username=" . $_SESSION['username']);