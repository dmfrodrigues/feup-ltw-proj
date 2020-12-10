<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/notifications.php';
include_once SERVER_DIR.'/users.php';
include_once SERVER_DIR.'/pets.php';

if ($_GET['username'] != $_SESSION['username']) 
    header("Location: " . $_SERVER['HTTP_REFERER']);

changeAdoptionRequestOutcome($_GET['requestId'], $_GET['outcome']);

$pet = Pet::fromDatabase($_GET['petId']);

if($_GET['outcome'] === 'accepted') {    
    changePetStatus($_GET['petId'], 'adopted');
    refuseOtherProposals($_GET['requestId'], $_GET['petId']);

    $userWhoAdopted = getUserWhoAdoptedPet($_GET['petId']);
    $userWhoPostedPet = $pet->getPostedBy(true);

    addNotification($userWhoAdopted['username'], "adoptionProposalOutcome", "Your proposal for ". $pet->getName() . ", posted by " . $userWhoPostedPet . " was accepted.");
}

if($_GET['outcome'] === 'rejected') {    
    
    $adoptionRequest = getAdoptionRequest($_GET['requestId']);
    $userWhoProposed = $adoptionRequest['user'];
    $userWhoPostedPet = $adoptionRequest['postedBy'];

    addNotification($userWhoProposed, "adoptionProposalOutcome", "Your proposal for ". $pet->getName() . ", posted by " . $userWhoPostedPet . " was refused.");
}
    
header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username=" . $_SESSION['username']);
