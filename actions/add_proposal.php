<?php

session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$petId = $_GET['id'];

if (isset($_SESSION['username'])){
    addAdoptionRequest($_SESSION['username'], $petId, $_POST['description']);

    $pet = Pet::fromDatabase($petId);
    $petOwner = $pet->getPostedBy();

    $petNameLink = "<a href='pet/{$pet->getId()}'>{$pet->getName()}</a>";
    $userLink = "<a href='user/{$_SESSION['username']}'>{$_SESSION['username']}</a>";

    addNotification($petOwner, "newPetAdoptionProposal", "You have a new adoption proposal for $petNameLink by $userLink.");

    header("Location: " . PROTOCOL_API_URL . "/pet/$petId");
}

die();