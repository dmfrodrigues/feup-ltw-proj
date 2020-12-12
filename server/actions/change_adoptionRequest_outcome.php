<?php
session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/users.php';
require_once SERVER_DIR.'/pets.php';
require_once SERVER_DIR.'/shelters.php';

if ($_GET['username'] != $_SESSION['username']) 
    header("Location: " . $_SERVER['HTTP_REFERER']);

changeAdoptionRequestOutcome($_GET['requestId'], $_GET['outcome']);

$pet = Pet::fromDatabase($_GET['petId']);

if($_GET['outcome'] === 'accepted') {    
    changePetStatus($_GET['petId'], 'adopted');
    $refusedUsers = refuseOtherProposals($_GET['requestId'], $_GET['petId']);

    $userWhoAdopted = Pet::fromDatabase($_GET['petId'])->getAdoptedBy();
    $userWhoPostedPet = $pet->getPostedBy();
    addNotification($userWhoAdopted->getUsername(), "adoptionProposalOutcome", "Your proposal for ". $pet->getName() . ", posted by " . $userWhoPostedPet->getUsername() . " was accepted.");

    foreach($refusedUsers as $refusedUser) {
        addNotification($refusedUser->getUsername(), "proposedPetAdopted", "The pet you proposed, " . $pet->getName() . ", posted by " . $userWhoPostedPet->getUsername() . " was adopted by " . $userWhoAdopted->getUsername() . ".");
    }
    addNotification($userWhoAdopted->getUsername(), "adoptionProposalOutcome", "Your proposal for ". $pet->getName() . ", posted by " . $userWhoPostedPet->getUsername() . " was accepted.");

    $usersWhoFavoritePet = getUsersWhoFavoritePet($_GET['petId']);
    foreach($usersWhoFavoritePet as $userWhoFavoritePet) {
        if ($userWhoFavoritePet['username'] !== $userWhoAdopted->getUsername() && $userWhoFavoritePet['username'] !== $userWhoPostedPet->getUsername())
            addNotification($userWhoFavoritePet['username'], "favoriteAdopted", "Your favorite pet " . $pet->getName() . ", posted by " . $userWhoPostedPet->getUsername() . " was adopted by " . $userWhoAdopted->getUsername() . ".");
    }

    $shelter = getPetShelter($_GET['petId']);
    if ($shelter !== null) {
        addNotification($shelter, "associatedPetAdopted", "Your associated pet " . $pet->getName() . ", posted by " . $userWhoPostedPet->getUsername() . " was adopted by " . $userWhoAdopted->getUsername() . ".");
        $collaborators = Shelter::fromDatabase($shelter)->getCollaborators();
        foreach($collaborators as $collaborator) {
            if ($collaborator->getUsername() !== $userWhoAdopted->getUsername() && $collaborator->getUsername() !== $userWhoPostedPet->getUsername())
                addNotification($collaborator->getUsername(), "associatedPetAdopted", "Your associated pet " . $pet->getName() . ", posted by " . $userWhoPostedPet->getUsername() . " was adopted by " . $userWhoAdopted->getUsername() . ".");
        }
    }

}

if($_GET['outcome'] === 'rejected') {    
    
    $adoptionRequest = getAdoptionRequest($_GET['requestId']);
    $userWhoProposed = $adoptionRequest['user'];
    $userWhoPostedPet = $adoptionRequest['postedBy'];
    addNotification($userWhoProposed, "adoptionProposalOutcome", "Your proposal for ". $pet->getName() . ", posted by " . $userWhoPostedPet . " was refused.");
}
    
header("Location: " . PROTOCOL_CLIENT_URL . "/profile.php?username=" . $_SESSION['username']);
