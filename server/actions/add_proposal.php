<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/notifications.php';
include_once SERVER_DIR.'/pets.php';
include_once SERVER_DIR.'/users.php';

$petId = $_GET['id'];

if (isset($_SESSION['username'])){
    addAdoptionRequest($_SESSION['username'], $petId, $_POST['description']);

    $pet = Pet::fromDatabase($petId);
    $petOwner = $pet->getPostedBy(true);

    addNotification($petOwner, "newPetAdoptionProposal", "You have a new adoption proposal for ". $pet->getName() . ", by " . $_SESSION['username'] . ".");

    header("Location: " . PROTOCOL_CLIENT_URL . "/pet.php?id=$petId");
}

die();