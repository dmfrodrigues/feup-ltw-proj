<?php

require_once __DIR__.'/server.php';
require_once SERVER_DIR.'/User.php';
require_once 'rest/authentication.php';
require_once __DIR__.'/Pet.php';

define('SHELTERS_IMAGES_DIR', SERVER_DIR.'/resources/img/shelters');

use function Authentication\noHTML;

class Shelter extends User {
    private string $description;
    private string $location;
    public function __construct(){}

    public function getDescription() : string { return noHTML($this->description) ; }
    public function getLocation   () : string { return noHTML($this->location)    ; }

    public function setDescription(string $description) : void {
        $newDescription = filter_var($description, FILTER_SANITIZE_STRING);
        $this->description = $newDescription; 
    }
    public function setLocation   (string $location   ) : void {
        $newLocation = filter_var($location, FILTER_SANITIZE_STRING);
        $this->location = $newLocation; 
    }

    public function jsonSerialize() {
        $ret = parent::jsonSerialize();
        $ret = $ret + get_object_vars($this);
        return $ret;
    }

    static public function fromDatabase(string $username) : ?Shelter {
        global $db;
        $stmt = $db->prepare('SELECT
        User.username,
        User.password,
        User.name,
        User.registeredOn,
        User.shelter,
        Shelter.description,
        Shelter.location
        FROM User NATURAL JOIN Shelter
        WHERE User.username=:username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $obj = $stmt->fetch();
        if($obj == false) return null;
        $shelter = new Shelter();
        $shelter->setUsername    ($obj['username'    ]);
        $shelter->setPassword    ($obj['password'    ]);
        $shelter->setName        ($obj['name'        ]);
        $shelter->setRegisteredOn($obj['registeredOn']);
        $shelter->setShelter     ($obj['shelter'     ]);
        $shelter->setDescription ($obj['description' ]);
        $shelter->setLocation    ($obj['location'    ]);
        return $shelter;
    }

    /**
     * Get Shelter pets for adoption
     *
     * @return array            Array containing all the info about the pets
     */
    public function getPetsForAdoption() : array {
        global $db;
    
        $stmt = $db->prepare('SELECT * FROM PET
            WHERE postedBy IN (
                SELECT username FROM User
                WHERE shelter=:shelter
            ) AND Pet.status="forAdoption"
        ');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->bindValue(':shelter', $this->getUsername());
        $stmt->execute();
        $shelterPets = $stmt->fetchAll();

        return $shelterPets;
    }

    /**
     * Get shelter collaborators.
     *
     * @return array            Array containing collaborators (Users)
     */
    public function getCollaborators() : array {
        global $db;

        $stmt = $db->prepare('SELECT * FROM User 
        WHERE shelter=:shelter');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
        $stmt->bindValue(':shelter', $this->getUsername());
        $stmt->execute();
        $collaborators = $stmt->fetchAll();
        return $collaborators;
    }
}

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
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $shelter = $stmt->fetch();
    
    return (!$shelter) ? false : true;
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
function addShelter(string $username, string $name, string $location, string $description, string $password, string $email){
    global $db;

    if (User::exists($username))
        throw new UserAlreadyExistsException("The username ".$username." already exists! Please choose another one!");
    
    addUser($username, $password, $email, $name);
    
    $stmt2 = $db->prepare('INSERT INTO Shelter(username, location, description) VALUES
    (:username, :location, :description)');
    $stmt2->bindValue(':username', $username);
    $stmt2->bindValue(':location', $location);
    $stmt2->bindValue(':description', $description);
    $stmt2->execute();
}


function getShelterPetsForAdoption(string $shelter) : array {
    return Shelter::fromDatabase($shelter)->getPetsForAdoption();
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

    $stmt->bindValue(':shelter', $shelter);
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
        if (User::exists($newUsername))
            throw new UserAlreadyExistsException("The username ".$newUsername." already exists! Please choose another one!");

    if($newUsername === "new") {
        throw new InvalidUsernameException("The username ".$newUsername." is invalid! Please choose another one!");
    }
    
    $stmt1 = $db->prepare('UPDATE User
        SET username=:newUsername, name=:name
        WHERE username=:lastUsername
    ');
    $stmt1->bindValue(':newUsername', $newUsername);
    $stmt1->bindValue(':lastUsername', $lastUsername);
    $stmt1->bindValue(':name', $name);
    $stmt1->execute();
    changePictureUsername($lastUsername, $newUsername);


    $stmt2 = $db->prepare('UPDATE Shelter
        SET location=:location, description=:description 
        WHERE username=:newUsername
    ');

    $stmt2->bindValue(':newUsername', $newUsername);
    $stmt2->bindValue(':location', $location);
    $stmt2->bindValue(':description', $description);
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

    $stmt->bindValue(':text', $text);
    $stmt->bindValue(':user', $username);
    $stmt->bindValue(':shelter', $shelter);
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
    $stmt1->bindValue(':username', $username);
    $stmt1->bindValue(':shelter', $shelter);
    $stmt1->execute();
    $isPending = $stmt1->fetch();
    if(!$isPending) 
        return false;
    return true;
}

/**
 * Removes a user from the shelter.
 *
 * @param string $username  Username
 * @return void
 */
function removeShelterCollaborator(string $username): void {
    global $db;

    $stmt = $db->prepare('UPDATE
        User SET shelter = NULL
        WHERE username=:username 
    ');
    
    $stmt->bindValue(':username', $username);
    $stmt->execute();
}

/**
 * Check if a user's already member of a Shelter
 *
 * @param string $username  Username 
 * @return bool             True if it is, false otherwise.
 */
function checkUserBelongsToShelter(string $username) : bool {
    global $db;

    $stmt = $db->prepare('SELECT 
        * FROM User
        WHERE username=:username AND shelter IS NOT NULL 
    ');
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    return (bool) $stmt->fetchColumn() > 0;
}

/**
 * Accept a Shelter Invitation
 *
 * @param string $username  Username (User)
 * @param string $shelter   Username (Shelter)
 * @return bool True if successful, false otherwise.
 */
function acceptShelterInvite(string $username, string $shelter) : bool {
    global $db;


    if(!checkUserBelongsToShelter($username)) {
        if(shelterInvitationIsPending($username, $shelter)) { 
            $stmt = $db->prepare('UPDATE User
            SET shelter=:shelter WHERE username=:username
            ');
            $stmt->bindValue(':shelter', $shelter);
            $stmt->bindValue(':username', $username);
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
 * @return bool True if successful. False otherwise.
 */
function deleteShelterInvitation(string $user, string $shelter) : bool {
    global $db;

    $stmt = $db->prepare('DELETE FROM ShelterInvite
        WHERE user=:username AND shelter=:shelter
    ');
    $stmt->bindValue(':username', $user);
    $stmt->bindValue(':shelter', $shelter);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

/**
 * Leave a shelter.
 *
 * @param string $username  Username 
 * @return void
 */
function leaveShelter(string $username): void {
    global $db;

    $stmt = $db->prepare('UPDATE User
        SET shelter = NULL WHERE username=:username
    ');
    $stmt->bindValue(':username', $username);
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

    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $shelterInvitations = $stmt->fetchAll();
    return $shelterInvitations;
}

/**
 * Get the shelter the pet is associated, or null if there is none.
 *
 * @param int $petId          Pet's ID
 * @return string             Shelter the user is associated, or null if there is none.
 */
function getPetShelter(int $petId) : ?string {

    $pet = Pet::fromDatabase($petId);
    $owner = $pet->getPostedById();

    return User::fromDatabase($owner)->getShelterId();
}

/**
 * Get the shelter invitation that were not answered yet.
 *
 * @param string $shelter   Username (Shelter)
 * @return array
 */
function getShelterPendingInvitations(string $shelter) : array {
    global $db;

    $stmt = $db->prepare('SELECT
        *
        FROM ShelterInvite
        WHERE shelter=:shelter
    ');
    $stmt->bindValue(':shelter', $shelter);
    $stmt->execute();
    $pendingInvitations = $stmt->fetchAll();
    return $pendingInvitations;
}

/**
 * Checks if the user can edit the pet.
 *
 * @param string $username  Username (User)
 * @param int    $petId     Pet ID
 * @return bool True if successful. False otherwise.
 */
function userCanEditPet(string $username, int $petId) : bool {

    $pet = Pet::fromDatabase($petId);

    if (isShelter($username)) {
        $pets = Shelter::fromDatabase($username)->getPetsForAdoption();

        foreach($pets as $p) {
            if ($p->getId() == $pet->getId()) return true;
        }

        return false;

    } else {
        $postedBy = $pet->getPostedBy();
        if ($postedBy->getUsername() == $username) return true;
        $shelter1 = User::fromDatabase($username)->getShelterId();
        $shelter2 = $postedBy->getShelterId();
        if (!is_null($shelter1) && ($shelter1 === $shelter2)) return true;
    }

    return false;
}

/**
 * Returns array with all shelters
 *
 * @return array           Array of shelters
 */
function getAllShelters() : array {
    global $db;
    $stmt = $db->prepare('SELECT
        *
        FROM Shelter
    ');
    $stmt->execute();
    return $stmt->fetchAll();
}
