<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/pets.php';

if ($_GET['username'] != $_SESSION['username']) 
    header("Location: " . $_SERVER['HTTP_REFERER']);

changeAdoptionRequestOutcome($_GET['requestId'], $_GET['outcome']);

if($_GET['outcome'] === 'accepted') {    
    changePetStatus($_GET['petId'], 'adopted');
    refuseOtherProposals($_GET['requestId'], $_GET['petId']);
}
    
header("Location: profile.php?username=" . $_SESSION['username']);
