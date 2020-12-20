<?php

// session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/Shelter.php';

$user = User::fromDatabase($_GET['username']);

if ($user->getUsername() != $_SESSION['username']) 
    header("Location: " . $_SERVER['HTTP_REFERER']);

changeAdoptionRequestOutcome($_GET['requestId'], $_GET['outcome']);

$pet = Pet::fromDatabase($_GET['petId']);

$petNameLink = "<a href='pet/{$pet->getId()}'>{$pet->getName()}</a>";

if($_GET['outcome'] === 'accepted') {    
    changePetStatus($_GET['petId'], 'adopted');
    $refusedUsers = refuseOtherProposals($_GET['requestId'], $_GET['petId']);

    $userWhoAdopted = Pet::fromDatabase($_GET['petId'])->getAdoptedBy();
    $userWhoPostedPet = $pet->getPostedBy();
    $userWhoPostedPetLink = "<a href='user/{$userWhoPostedPet->getUsername()}'>{$userWhoPostedPet->getUsername()}</a>";
    $userWhoAdoptedLink = "<a href='user/{$userWhoAdopted->getUsername()}'>{$userWhoAdopted->getUsername()}</a>";
    addNotification($userWhoAdopted, "adoptionProposalOutcome", "Your proposal for ". $petNameLink . ", posted by " . $userWhoPostedPetLink . " was accepted.");

    foreach($refusedUsers as $refusedUser) {
        addNotification($refusedUser, "proposedPetAdopted", "The pet you proposed, " . $petNameLink . ", posted by " . $userWhoPostedPetLink . " was adopted by " . $userWhoAdoptedLink . ".");
    }

    $usersWhoFavoritePet = getUsersWhoFavoritePet($_GET['petId']);
    foreach($usersWhoFavoritePet as $userWhoFavoritePet) {
        if ($userWhoFavoritePet['username'] !== $userWhoAdopted->getUsername() && $userWhoFavoritePet['username'] !== $userWhoPostedPet->getUsername())
            addNotification(User::fromDatabase($userWhoFavoritePet['username']), "favoriteAdopted", "Your favorite pet " . $petNameLink . ", posted by " . $userWhoPostedPetLink . " was adopted by " . $userWhoAdoptedLink . ".");
    }

    $shelterId = getPetShelter($_GET['petId']);
    $shelter = Shelter::fromDatabase($shelterId);
    if ($shelter !== null) {
        addNotification($shelter, "associatedPetAdopted", "Your associated pet " . $petNameLink . ", posted by " . $userWhoPostedPetLink . " was adopted by " . $userWhoAdoptedLink . ".");
        $collaborators = $shelter->getCollaborators();
        foreach($collaborators as $collaborator) {
            if ($collaborator->getUsername() !== $userWhoAdopted->getUsername() && $collaborator->getUsername() !== $userWhoPostedPet->getUsername())
                addNotification($collaborator, "associatedPetAdopted", "Your associated pet " . $petNameLink . ", posted by " . $userWhoPostedPetLink . " was adopted by " . $userWhoAdoptedLink . ".");
        }
    }

}

if($_GET['outcome'] === 'rejected') {    
    
    $adoptionRequest = getAdoptionRequest($_GET['requestId']);
    $userWhoProposed = User::fromDatabase($adoptionRequest['user']);
    $userWhoPostedPet = $adoptionRequest['postedBy'];
    $userWhoPostedPetLink = "<a href='user/{$userWhoPostedPet}'>{$userWhoPostedPet}</a>";
    addNotification($userWhoProposed, "adoptionProposalOutcome", "Your proposal for $petNameLink, posted by $userWhoPostedPetLink was refused.");
}
    
header_location("/user/{$_SESSION['username']}/proposalstome");
