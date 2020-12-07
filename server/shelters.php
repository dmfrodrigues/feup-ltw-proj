<?php

include_once __DIR__.'/server.php';
include_once SERVER_DIR.'/users.php';
include_once __DIR__.'/pets.php';

define('SHELTERS_IMAGES_DIR', SERVER_DIR.'/resources/img/shelters');


/**
 * Get Shelter info.
 *
 * @param string $shelter  Username (Shelter)
 * @return array          Array containg the shelter's info.
 */
function getShelter(string $shelter) : array {
    global $db;

    $stmt = $db->prepare('SELECT 
        name,
        location,
        description,
        registeredOn
        FROM Shelter
        WHERE username=:shelter
    ');
    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    $shelterInfo = $stmt->fetch();
    $shelterInfo['pictureUrl'] = getShelterPicture($shelter);
    return $shelterInfo;
}

/**
 * Get user Shelter's picture URL.
 *
 * @param string $username  Username (Shelter)
 * @return ?string           URL of user Shelter's picture, or null if there is none
 */
function getShelterPicture(string $shelter) : ?string {
    $url = "../server/resources/img/shelters/$shelter.jpg";
    if(!file_exists($url)) $url = null;
    return $url;
}

/**
 * Save new shelter picture.
 *
 * @param string $username  Shelter's username
 * @param array $file       File (as obtained from $_FILES['file_field'])
 * @return void
 */
function saveShelterPicture(string $shelter, array $file){
    $ext = checkImageFile($file, 1000000);

    $filepath = SHELTERS_IMAGES_DIR."/$shelter.jpg";
    convertImage(
        $file['tmp_name'],
        $ext,
        $filepath,
        85
    );
}

/**
 * Change the name of the shelter's picture when the username is changed
 *
 * @param string $oldUsername  Shelters's old username
 * @param string $newUsername  Shelters's new username
 * @return void
 */
function changePictureShelter(string $oldUsername, string $newUsername) {
    $oldFilepath = SHELTERS_IMAGES_DIR."/$oldUsername.jpg";
    $newFilepath = SHELTERS_IMAGES_DIR."/$newUsername.jpg";
    rename($oldFilepath, $newFilepath);
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

    if (userAlreadyExists($username) || shelterAlreadyExists($username))
        throw new UserAlreadyExistsException("The username ".$username." already exists! Please choose another one!");
    
    $password_sha1 = sha1($password);
    $stmt = $db->prepare('INSERT INTO Shelter(username, name, location, description, password) VALUES
    (:username, :name, :location, :description, :password)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':name'    , $name);
    $stmt->bindParam(':location',$location);
    $stmt->bindParam(':description',$description);
    $stmt->bindParam(':password', $password_sha1);
    
    $stmt->execute();
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
 * Check if Shelter already exists.
 *
 * @param string $username  Username
 * @return boolean          True if the user exists, false otherwise
 */
function shelterAlreadyExists(string $username) : bool {
    global $db;
    $stmt = $db->prepare('SELECT username
    FROM Shelter
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $shelters = $stmt->fetchAll();
    return (count($shelters) > 0);
}

/**
 * Get Shelter pets for adoption
 *
 * @param string $username  Username (Shelter)
 * @return array            Array containing all the info about the pets
 */
function getShelterPetsForAdoption(string $username) : array {
    global $db;
    
    $stmt = $db->prepare('SELECT 
            Shelter.username AS shelter,
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
        FROM Shelter
        JOIN User ON Shelter.username = User.shelter
        JOIN Pet ON User.username = Pet.postedBy
        WHERE Shelter.username=:username AND Pet.status="forAdoption"
    ');

    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $shelterPets = $stmt->fetchAll();

    return $shelterPets;
}

/**
 * Get already adopted Shelter pets.
 *
 * @param string $username  Username (Shelter)
 * @return array            Array containing all the info about the pets
 */
function getShelterAdoptedPets(string $username) : array {
    global $db;
    
    $stmt = $db->prepare('SELECT 
            Shelter.username AS shelter,
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
        FROM Shelter
        JOIN User ON Shelter.username = User.shelter
        JOIN Pet ON User.username = Pet.postedBy
        WHERE Shelter.username=:username AND Pet.status<>"forAdoption"
    ');

    $stmt->bindParam(':username', $username);
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
        if (userAlreadyExists($newUsername) || shelterAlreadyExists($newUsername))
            throw new UserAlreadyExistsException("The username ".$newUsername." already exists! Please choose another one!");
    
    $stmt = $db->prepare('UPDATE Shelter
        SET username=:newUsername name=:name, location=:location, description=:description 
        WHERE username=:lastUsername
    ');

    $stmt->bindParam(':newUsername', $newUsername);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':lastUsername', $lastUsername);
    $stmt->execute();
    changePictureShelter($lastUsername, $newUsername);

    return $stmt->rowCount() > 0;
}

/**

 * Edit user password.
 *
 * @param string $username  User's username
 * @param string $password  User's password
 * @return void
 */
function editShelterPassword(string $username, string $password) {
    global $db;
    $password_sha1 = sha1($password);
    $stmt = $db->prepare('UPDATE Shelter SET
    password=:password
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_sha1);
    $stmt->execute();
}

/**
 * Add a Shelter invitation to a specific user
 *
 * @param string $text         Message Info
 * @param string $username     Username (User)
 * @param string $shelter      Username (Shelter)
 * @return array            Array containing all the info about the pets
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
 * @return array            Array containing all the info about the colaborators
 */
function getShelterCollaborators(string $shelter) : array {
    global $db;

    $stmt = $db->prepare('SELECT 
            Shelter.username AS shelter,
            User.username AS user,
            User.name
        FROM Shelter
        JOIN User ON Shelter.username = User.shelter
        WHERE User.shelter=:shelter
    ');
    $stmt->bindParam(':shelter', $shelter);
    $stmt->execute();
    $shelterCollaborators = $stmt->fetchAll();

    $collaboratorsWithPhoto = [];
    foreach($shelterCollaborators as $collaborator){
        $collaborator['pictureUrl'] = getUserPicture($collaborator['user']);
        array_push($collaboratorsWithPhoto, $collaborator);
    }

    return $collaboratorsWithPhoto;
}
