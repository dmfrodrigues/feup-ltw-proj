<?php

require_once __DIR__.'/server.php';
require_once SERVER_DIR.'/users.php';
require_once __DIR__.'/pets.php';

define('SHELTERS_IMAGES_DIR', SERVER_DIR.'/resources/img/shelters');

/**
 * Checks if the username is from a shelter.
 *
 * @param string $username  Username (Shelter's or User's)
 * @return bool             true if the $username is from a shelter; false otherwise.
 */
function isShelter(string $username) : bool {
    global $db;

    $stmt = $db->prepare('SELECT username
        FROM Shelter
        WHERE username=:username
    ');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $shelter = $stmt->fetch();
    
    return (!$shelter) ? false : true;
}

/**
 * Get Shelter info.
 *
 * @param string $shelter  Username (Shelter)
 * @return array           Array containing the shelter's info.
 */
function getShelter(string $shelter) : array {
    global $db;

    $stmt = $db->prepare('SELECT
        User.username,
        User.name,
        Shelter.location,
        Shelter.description
        FROM Shelter
        JOIN User ON User.username = Shelter.username 
        WHERE User.username=:shelter
    ');
    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    $shelterInfo = $stmt->fetch();
    $shelterInfo['pictureUrl'] = getUserPicture($shelter);
    return $shelterInfo;
}

/**
 * Add shelter to database.
 *
 * @param string $username     Shelter's username
 * @param string $name         Shelter's name
 * @param string $location     Shelter's location
 * @param string $description  Shelter's description
 * @param string $password     Password
 * @return void
 */
function addShelter(string $username, string $name, string $location, string $description, $password){
    global $db;

    if (userAlreadyExists($username))
        throw new UserAlreadyExistsException("The username ".$username." already exists! Please choose another one!");
    
    addUser($username, $password, $name);
    
    $stmt2 = $db->prepare('INSERT INTO Shelter(username, location, description) VALUES
    (:username, :location, :description)');
    $stmt2->bindParam(':username', $username);
    $stmt2->bindParam(':location', $location);
    $stmt2->bindParam(':description', $description);
    $stmt2->execute();
}

/**
 * Get Shelter pets for adoption
 *
 * @param string $shelter  Username (Shelter)
 * @return array            Array containing all the info about the pets
 */
function getShelterPetsForAdoption(string $shelter) : array {
    global $db;
    
    $stmt = $db->prepare('SELECT 
            User.username AS user,
            Pet.id,
            Pet.name,
            Pet.species,
            Pet.age,
            Pet.sex,
            Pet.size,
            Pet.color,
            Pet.location,
            Pet.description
        FROM User
        JOIN Pet ON User.username = Pet.postedBy
        WHERE User.shelter=:shelter AND Pet.status="forAdoption"
    ');

    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    $shelterPets = $stmt->fetchAll();

    return $shelterPets;
}

/**
 * Get already adopted Shelter pets.
 *
 * @param string $shelter  Username (Shelter)
 * @return array            Array containing all the info about the pets
 */
function getShelterAdoptedPets(string $shelter) : array {
    global $db;
    
    $stmt = $db->prepare('SELECT 
            User.username AS user,
            Pet.id,
            Pet.name,
            Pet.species,
            Pet.age,
            Pet.sex,
            Pet.size,
            Pet.color,
            Pet.location,
            Pet.description
        FROM User
        JOIN Pet ON User.username = Pet.postedBy
        WHERE User.shelter=:shelter AND Pet.status<>"forAdoption"
    ');

    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    $shelterPets = $stmt->fetchAll();

    return $shelterPets;
}

/**
 * Update Shelter Info
 *
 * @param string $lastUsername    Last username (Shelter)
 * @param string $newUsername     New username (Shelter)
 * @param string $name            Name
 * @param string $location        Location
 * @param string $description     Description
 * @return boolean                True if the successful, false otherwise
 */
function updateShelterInfo(string $lastUsername, string $newUsername, string $name, string $location, string $description) : bool {
    global $db;

    if($lastUsername != $newUsername)
        if (userAlreadyExists($newUsername))
            throw new UserAlreadyExistsException("The username ".$newUsername." already exists! Please choose another one!");
    
    $stmt1 = $db->prepare('UPDATE User
        SET username=:newUsername, name=:name
        WHERE username=:lastUsername
    ');
    $stmt1->bindParam(':newUsername', $newUsername);
    $stmt1->bindParam(':lastUsername', $lastUsername);
    $stmt1->bindParam(':name', $name);
    $stmt1->execute();
    changePictureUsername($lastUsername, $newUsername);


    $stmt2 = $db->prepare('UPDATE Shelter
        SET location=:location, description=:description 
        WHERE username=:newUsername
    ');

    $stmt2->bindParam(':newUsername', $newUsername);
    $stmt2->bindParam(':location', $location);
    $stmt2->bindParam(':description', $description);
    $stmt2->execute();

    return ($stmt1->rowCount() > 0 && $stmt2->rowCount() > 0);
}

/**
 * Add a Shelter invitation to a specific user
 *
 * @param string $text         Message Info
 * @param string $username     Username (User)
 * @param string $shelter      Username (Shelter)
 * @return bool                True if success; false otherwise.
 */
function addShelterInvitation(string $text, string $username, string $shelter) : bool {
    global $db;

    $stmt = $db->prepare('INSERT INTO 
        ShelterInvite(text, user, shelter)
        VALUES (:text, :user, :shelter)
    ');

    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':user', $username);
    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

/**
 * Get a shelter invitation
 *
 * @param string $username     Username (User)
 * @param string $shelter      Username (Shelter)
 * @return bool                True if the invitation is pending; false otherwise
 */
function shelterInvitationIsPending(string $username, string $shelter) : bool {
    global $db;

    $stmt1 = $db->prepare('SELECT 
        * FROM ShelterInvite
        WHERE user=:username AND shelter=:shelter
    ');
    $stmt1->bindParam(':username', $username);
    $stmt1->bindParam(':shelter', $shelter);
    $stmt1->execute();
    $isPending = $stmt1->fetch();
    if(!$isPending) 
        return false;
    return true;
}

/**
 * Get Shelter Collaborators.
 *
 * @param string $username  Username (Shelter)
 * @return array            Array containing all the info about the collaborators
 */
function getShelterCollaborators(string $shelter) : array {
    global $db;

    $stmt = $db->prepare('SELECT 
            shelter,
            username as user,
            name
        FROM User 
        WHERE shelter=:shelter
    ');
    
    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    $shelterCollaborators = $stmt->fetchAll();

    $collaboratorsWithPhoto = [];
    foreach($shelterCollaborators   as $collaborator){
        $collaborator['pictureUrl'] = getUserPicture($collaborator['user']);
        array_push($collaboratorsWithPhoto, $collaborator);
    }

    return $collaboratorsWithPhoto;
}

/**
 * Get Users that can join the shelter.
 *
 * @return array            Array containing all the info about the users.
 */
function getUsersAvailableForShelter() : array {
    global $db;

    $stmt = $db->prepare('SELECT
        username as user, 
        name,
        registeredOn,
        shelter
        FROM User
        WHERE shelter is NULL
    ');

    $stmt->execute();
    $totalUsers = $stmt->fetchAll();
    $returnUsers = [];
    foreach($totalUsers as $user) {
        if(!isShelter($user['user']) && !checkUserBelongsToShelter($user['user'])) {
            $user['pictureUrl'] = getUserPicture($user['user']);
            array_push($returnUsers, $user);
        }   
    }

    return $returnUsers;
}

/**
 * Removes a user from the shelter.
 *
 * @param string $username  Username
 */
function removeShelterCollaborator(string $username) {
    global $db;

    $stmt = $db->prepare('UPDATE
        User SET shelter = NULL
        WHERE username=:username 
    ');
    
    $stmt->bindParam(':username', $username);
    $stmt->execute();
}

/**
 * Check if a user's already member of a Shelter
 *
 * @param string $username  Username 
 * @return array            True if it is, false otherwise.
 */
function checkUserBelongsToShelter(string $username) : bool {
    global $db;

    $stmt = $db->prepare('SELECT 
        * FROM User
        WHERE username=:username AND shelter IS NOT NULL 
    ');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return (bool) $stmt->fetchColumn() > 0;
}

/**
 * Accept a Shelter Invitation
 *
 * @param string $username  Username (User)
 * @param string $shelter   Username (Shelter)
 * @return array            True if successful, false otherwise.
 */
function acceptShelterInvite(string $username, string $shelter) : bool {
    global $db;


    if(!checkUserBelongsToShelter($username)) {
        if(shelterInvitationIsPending($username, $shelter)) { 
            $stmt = $db->prepare('UPDATE User
            SET shelter=:shelter WHERE username=:username
            ');
            $stmt->bindParam(':shelter', $shelter);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            deleteShelterInvitation($username, $shelter);
            return true;
        }
    }

    return false;
}

/**
 * Delete Shelter Invitation
 *
 * @param string $user     Username (User)
 * @param string $shelter  Username (Shelter)
 * @return array           True if successful. False otherwise.
 */
function deleteShelterInvitation(string $user, string $shelter) : bool {
    global $db;

    $stmt = $db->prepare('DELETE FROM ShelterInvite
        WHERE user=:username AND shelter=:shelter
    ');
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

/**
 * Leave a shelter.
 *
 * @param string $username  Username 
 */
function leaveShelter(string $username) {
    global $db;

    $stmt = $db->prepare('UPDATE User
        SET shelter = NULL WHERE username=:username
    ');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
}

/**
 * Get shelter invitations of a specific user.
 *
 * @param string $username  Username 
 * @return array            Array containing all the Shelter Invitations of the user.
 */
function getUserShelterInvitation(string $username) : array {
    global $db;

    $stmt = $db->prepare('SELECT 
        * FROM ShelterInvite
        WHERE user=:username
    ');

    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $shelterInvitations = $stmt->fetchAll();
    return $shelterInvitations;
}

/**
 * Get the shelter the user is associated, or null if there is none.
 *
 * @param string $username  Username (User)
 * @return string           Shelter the user is associated, or null if there is none.
 */
function getUserShelter(string $username) : ?string {
    global $db;

    $stmt = $db->prepare('SELECT shelter
        FROM User
        WHERE username=:username
    ');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $shelter = $stmt->fetch();
    return $shelter['shelter'];
}

/**
 * Get the shelter the pet is associated, or null if there is none.
 *
 * @param int $petId          Pet's ID
 * @return string             Shelter the user is associated, or null if there is none.
 */
function getPetShelter(int $petId) : ?string {

    $pet = getPet($petId);
    $owner = getUser($pet['postedBy']);

    return getUserShelter($owner['username']);
}

/**
 * Get the shelter invitation that were not answered yet.
 *
 * @param string $shelter   Username (Shelter)
 * @return string           Array containing all the shelter pending invitations.
 */
function getShelterPendingInvitations(string $shelter) : array {
    global $db;

    $stmt = $db->prepare('SELECT
        text,
        user,
        shelter,
        requestDate
        FROM ShelterInvite
        WHERE shelter=:shelter
    ');
    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    $pendingInvitations = $stmt->fetchAll();
    return $pendingInvitations;
}

/**
 * Checks if the user can edit the pet.
 *
 * @param string $username     Username (User)
 * @param string $shelter  Username (Shelter)
 * @return array           True if successful. False otherwise.
 */
function userCanEditPet($username, $petId) : bool {

    $pet = getPet((int) $petId);

    if (isShelter($username)) {
        $pets = getShelterPetsForAdoption($username);

        foreach($pets as $p) {
            if ($p['id'] == $pet['id']) return true;
        }

        return false;

        //if (in_array($pet, $pets, TRUE)) return true; // BUG AQUI!!!!
    }
    else {
        $postedByUsername = $pet['postedBy'];
        if ($postedByUsername === $username) return true;
        $shelter1 = getUserShelter($username);
        $shelter2 = getUserShelter($postedByUsername);
        if (!is_null($shelter1) && ($shelter1 === $shelter2)) return true;
    }

    return false;
}
