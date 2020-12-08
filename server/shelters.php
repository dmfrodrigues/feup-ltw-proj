<?php

include_once __DIR__.'/server.php';
include_once SERVER_DIR.'/users.php';
include_once __DIR__.'/pets.php';

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
 * @return array          Array containg the shelter's info.
 */
function getShelter(string $shelter) : array {
    global $db;

    $stmt = $db->prepare('SELECT 
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
 * Check if user-password pair is valid (Shelters).
 *
 * @param string $username  Username
 * @param string $password  Password
 * @return boolean          True if the user-password pair is correct for Shelter table, false otherwise
 */
function shelterPasswordExists(string $username, string $password) : bool {
    global $db;
    $password_sha1 = sha1($password);
    $stmt = $db->prepare('SELECT username
    FROM Shelter
    WHERE username=:username AND password=:password');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_sha1);
    $stmt->execute();
    $shelters = $stmt->fetchAll();
    return (count($shelters) > 0);
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
 * @param string $shelter       Username (Shelter)
 * @param string $name          Shelter Name
 * @param string $location      Location
 * @param string $description   Description
 * @return boolean              True if the successful, false otherwise
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
 * @return array               Array containing all the info about the pets
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
