<?php

require_once __DIR__.'/server.php';
require_once SERVER_DIR.'/files.php';
require_once __DIR__.'/pets.php';
require_once __DIR__.'/shelters.php';

define('USERS_IMAGES_DIR', SERVER_DIR.'/resources/img/profiles');

class UserAlreadyExistsException extends RuntimeException{}

class User implements JsonSerializable {
    private  string $username;
    private  string $password;
    private  string $name;
    private  string $registeredOn;
    private ?string $shelter;
    // private  bool   $admin;
    public function __construct(
        string $username     = '',
        string $password     = '',
        string $name         = '',
        string $registeredOn = '',
       ?string $shelter      = null
        // bool   $admin        = false
    ){
        $this->username     = $username;
        $this->password     = $password;
        $this->name         = $name;
        $this->registeredOn = $registeredOn;
        $this->shelter      = $shelter;
        // $this->admin = $admin;
    }

    public function getUsername    () :  string { return $this->username    ; }
    public function getPassword    () :  string { return $this->password    ; }
    public function getName        () :  string { return $this->name        ; }
    public function getRegisteredOn() :  string { return $this->registeredOn; }
    /**
     * @return Shelter|null|string
     */
    public function getShelter(bool $raw = false) {
        return ($raw ?
            $this->shelter :
            (Shelter::fromDatabase($this->shelter))
        );
    }
    // public function isAdmin        () :  bool   { return $this->admin       ; }
    public function isShelter() : bool {
        return (Shelter::fromDatabase($this->getUsername()) != null);
    }
    /**
     * Get user picture URL.
     *
     * @return ?string          URL of user profile picture, or null if there is none
     */
    function getPictureUrl() : ?string {
        $path = SERVER_DIR . "/resources/img/profiles/$this->username.jpg";
        if(!file_exists($path)) return null;
        return path2url($path);
    }

    public function setUsername    ( string $username    ) : void { $this->username     = $username    ; }
    public function setPassword    ( string $password, bool $hashed = true) : void {
        $this->password = ($hashed?
            $password :
            (User::hashPassword($password))
        );
    }
    public function setName        ( string $name        ) : void { $this->name         = $name        ; }
    public function setRegisteredOn( string $registeredOn) : void { $this->registeredOn = $registeredOn; }
    public function setShelter     (?string $shelter     ) : void { $this->shelter      = $shelter     ; }
    
    public function jsonSerialize() {
        $ret = get_object_vars($this);
        $ret['pictureUrl'] = $this->getPictureUrl();
        return $ret;
    }

    static public function hashPassword(string $password) : string {
        return sha1($password);
    }

    /**
     * Get users that can join a shelter.
     *
     * @return array            Array containing all the the users that can join a shelter.
     */
    static public function allWithoutShelter() : array {
        global $db;

        $stmt = $db->prepare('SELECT
            username, 
            password,
            name,
            registeredOn,
            shelter
            FROM User
            WHERE shelter is NULL
            AND username NOT IN (SELECT username FROM SHELTER)
        ');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
        $stmt->execute();
        $users = $stmt->fetchAll();
        
        return $users;
    }

    public function addToDatabase() : void {
        global $db;

        $stmt = $db->prepare('INSERT INTO User(username, password, name) VALUES
        (:username, :password, :name)');
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':name'    , $this->name);
        if(!$stmt->execute()) throw new RuntimeException();

        $newUser = User::fromDatabase($this->username);
        $this->setRegisteredOn($newUser->getRegisteredOn());
        $this->setShelter     ($newUser->getShelter     (true));
    }

    /**
     * Delete user.
     *
     * @param string $username  User's username
     * @return void
     */
    static public function deleteFromDatabase(string $username) : void {
        global $db;
        $user_pets = getAddedPets($username);
        foreach($user_pets as $i => $pet){
            $id = $pet->getId();
            $dir = PETS_IMAGES_DIR."/$id";
            rmdir_recursive($dir);
        }
        deleteUserPhoto($username);
        $stmt = $db->prepare('DELETE FROM User WHERE username=:username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }

    static public function fromDatabase(string $username) : ?User {
        global $db;
        $stmt = $db->prepare('SELECT * FROM User WHERE username=:username');
        $stmt->bindParam(':username', $username);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
        $stmt->execute();
        $user = $stmt->fetch();
        if($user == false) return null;
        return $user;
    }

    public function updateDatabase() : void {
        global $db;
        $stmt = $db->prepare('UPDATE User SET
        password=:password,
        name=:name,
        registeredOn=:registeredOn,
        shelter=:shelter
        WHERE username=:username');
        $stmt->bindParam(':username'    , $this->username    );
        $stmt->bindParam(':password'    , $this->password    );
        $stmt->bindParam(':name'        , $this->name        );
        $stmt->bindParam(':registeredOn', $this->registeredOn);
        $stmt->bindParam(':shelter'     , $this->shelter     );
        $stmt->execute();
    }

    static public function changeUsernameInDatabase(string $oldUsername, string $newUsername): void{
        global $db;

        if($oldUsername != $newUsername)
            if (User::exists($newUsername))
                throw new UserAlreadyExistsException("The username ".$newUsername." already exists! Please choose another one!");
            
        $stmt = $db->prepare('UPDATE User SET
        username=:newUsername,
        WHERE username=:oldUsername');
        $stmt->bindParam(':newUsername', $newUsername);
        $stmt->bindParam(':oldUsername', $oldUsername);
        $stmt->execute();
        changePictureUsername($oldUsername, $newUsername);
    }

    /**
     * Check if user already exists in database.
     *
     * @param string $username  Username
     * @return boolean          True if the user exists, false otherwise
     */
    static public function exists(string $username) : bool {
        global $db;
        $stmt = $db->prepare('SELECT username FROM User WHERE username=:username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $users = $stmt->fetchAll();
        return (count($users) > 0);
    }

    /**
     * Check if user-password pair is valid.
     *
     * @param string $username  Username
     * @param string $password  Password
     * @return boolean          True if the user-password pair is correct, false otherwise
     */
    static public function checkCredentials(string $username, string $password) : bool {
        global $db;
        $password_sha1 = sha1($password);
        $stmt = $db->prepare('SELECT username
        FROM User
        WHERE username=:username AND password=:password');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password_sha1);
        $stmt->execute();
        $users = $stmt->fetchAll();
        return (count($users) > 0);
    }

    public function getFavoritePets() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM PET
        WHERE id IN (
            SELECT petId FROM FavoritePet
            WHERE username=:username
        )');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }

    /**
     * Get pets added by a user that were not adopted yet.
     *
     * @param string $username  User's username
     * @return array            Array of pets added by that user
     */
    public function getPetsNotAdopted() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet 
        WHERE postedBy=:username
        AND status="forAdoption"');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }
}

class Shelter extends User {
    private string $description;
    private string $location;
    public function __construct(
        string $username     = '',
        string $password     = '',
        string $name         = '',
        string $registeredOn = '',
       ?string $shelter      = null,
        // bool   $admin        = false,
        string $description  = '',
        string $location     = ''
    ){
        parent::__construct(
            $username,
            $password,
            $name,
            $registeredOn,
            $shelter,
            // $admin
        );
        $this->description = $description;
        $this->location = $location;
    }

    public function getDescription() : string { return $this->description; }
    public function getLocation   () : string { return $this->location   ; }

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
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $obj = $stmt->fetch();
        if($obj == false) return null;
        $shelter = new Shelter(
            $obj['username'],
            $obj['password'],
            $obj['name'],
            $obj['registeredOn'],
            $obj['shelter'],
            false,
            $obj['description'],
            $obj['location']
        );
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
        $stmt->bindParam(':shelter', $this->getUsername());
        $stmt->execute();
        $shelterPets = $stmt->fetchAll();

        return $shelterPets;
    }
}

/**
 * Add user to database.
 *
 * @param string $username  User's username
 * @param string $password  Password
 * @param string $name      Real name
 * @return void
 */
function addUser(string $username, string $password, string $name){
    $user = new User($username, '', $name);
    $user->setPassword($password, false);
    $user->addToDatabase();
}

/**
 * Check if user is admin.
 *
 * @param string $username  User's username
 * @return boolean          True if user is admin, false otherwise
 */
// function isAdmin(string $username) : bool {
//     global $db;
//     $stmt = $db->prepare('SELECT username
//     FROM Admin
//     WHERE username=:username');
//     $stmt->bindParam(':username', $username);
//     $stmt->execute();
//     $admins = $stmt->fetchAll();
//     return (count($admins) == 1);
// }

/**
 * Edit user name.
 *
 * @param string $oldUsername   User's last username
 * @param string $newUsername   User's new username
 * @param string $name          User's name
 * @return void
 */
function editUser(string $oldUsername, string $newUsername, string $name) {
    $user = User::fromDatabase($oldUsername);
    $user->setName($name);
    $user->updateDatabase();

    User::changeUsernameInDatabase($oldUsername, $newUsername);
}


/**

 * Edit user password.
 *
 * @param string $username  User's username
 * @param string $password  User's password
 * @return void
 */
function editUserPassword(string $username, string $password) {
    $user = User::fromDatabase($username);
    var_dump($user);
    $user->setPassword($password, false);
    var_dump($user);
    $user->updateDatabase();
}

function deleteUser(string $username): void {
    User::deleteFromDatabase($username);
}

/**
 * Save new user picture.
 *
 * @param string $username  User's username
 * @param array $file       File (as obtained from $_FILES['file_field'])
 * @return string
 */
function setUserPhoto(string $username, string $tmpFilePath): string{
    $ext = checkImageFile($tmpFilePath, 1000000);

    $filepath = USERS_IMAGES_DIR."/$username.jpg";
    convertImage(
        $tmpFilePath,
        $ext,
        $filepath,
        85
    );

    return $filepath;
}

/**
 * Erase user picture.
 *
 * @param string $username  User's username
 * @return void
 */
function deleteUserPhoto(string $username){
    $filepath = USERS_IMAGES_DIR."/$username.jpg";
    if(file_exists($filepath))
        if(!unlink($filepath))
            throw new CouldNotDeleteFileException("Could not delete '$filepath'");
}

/**
 * Change the name of the user picture when the username is changed
 *
 * @param string $oldUsername  User's old username
 * @param string $newUsername  User's new username
 * @return void
 */
function changePictureUsername(string $oldUsername, string $newUsername) {
    $oldFilepath = USERS_IMAGES_DIR."/$oldUsername.jpg";
    $newFilepath = USERS_IMAGES_DIR."/$newUsername.jpg";
    rename($oldFilepath, $newFilepath);
}

 /**
  * Add pet to user's favorites list.
  *
  * @param string $username User's username
  * @param integer $id      ID of pet
  * @return void
  */
function addToFavorites(string $username, int $id){
    global $db;
    $favoritePets = User::fromDatabase($username)->getFavoritePets();
    foreach ($favoritePets as $pet)
        if ($pet->getId() == $id)
            return;
    $stmt = $db->prepare('INSERT INTO FavoritePet(username, petId) VALUES
            (:username, :id)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id'      , $id      );
    $stmt->execute();
}

/**
 * Remove pet from user's favorites list.
 *
 * @param string $username  User's username
 * @param integer $id       ID of pet
 * @return void
 */
function removeFromFavorites(string $username, int $id){
    global $db;
    $stmt = $db->prepare('DELETE FROM FavoritePet WHERE
    username=:username AND petId=:id');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id'      , $id      );
    $stmt->execute();
}

/**
 * Get a user's favorite pets.
 *
 * @param string $username  User's username
 * @return array            Array of favorite pets of the user 
 */
function getFavoritePets(string $username) : array {
    return User::fromDatabase($username)->getFavoritePets();
}

/**
 * Get a specific adoption request given it's id.
 * 
 * @param int $id   Adoption Request id
 * @return array    The adoption request with the pet's owner.
 */
function getAdoptionRequest(int $id): array {
    global $db;
    
    $stmt = $db->prepare('SELECT 
        AdoptionRequest.id,
        AdoptionRequest.text,
        AdoptionRequest.outcome,
        AdoptionRequest.pet,
        AdoptionRequest.user,
        AdoptionRequest.requestDate AS reqDate,
        Pet.postedBy,
        Pet.name AS petName
        FROM AdoptionRequest INNER JOIN Pet ON Pet.id=AdoptionRequest.pet
        WHERE AdoptionRequest.id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $adoptionRequest = $stmt->fetch();
    return $adoptionRequest;
}

function getAdoptionRequestMessages(int $reqId) : array {
    global $db;

    $stmt = $db->prepare('SELECT 
        AdoptionRequestMessage.text, 
        AdoptionRequestMessage.request,
        AdoptionRequestMessage.id,
        AdoptionRequestMessage.messageDate AS messDate,
        AdoptionRequestMessage.user,
        AdoptionRequest.outcome,
        AdoptionRequest.pet,
        Pet.name AS petName
        FROM AdoptionRequestMessage 
        INNER JOIN AdoptionRequest ON AdoptionRequest.id=AdoptionRequestMessage.request
        INNER JOIN Pet ON AdoptionRequest.pet=Pet.id
        WHERE AdoptionRequestMessage.request=:reqId');
    $stmt->bindParam(':reqId', $reqId);
    $stmt->execute();
    $adoptionRequestMessages = $stmt->fetchAll();
    return $adoptionRequestMessages;
} 

/**
 * Get a user's adoption requests.
 *
 * @param string $username  User's username
 * @return array            Array of adoption requests 
 */
function getAdoptionRequests(string $username) : array {
    global $db;

    $stmt = $db->prepare('SELECT
    Pet.id,
    Pet.name,
    Pet.species,
    Pet.age,
    Pet.sex,
    Pet.size,
    Pet.color,
    Pet.location,
    Pet.description,
    Pet.status,
    Pet.postedBy,
    AdoptionRequest.id AS requestId,
    AdoptionRequest.text,
    AdoptionRequest.outcome,
    AdoptionRequest.user,
    AdoptionRequest.requestDate
    FROM Pet INNER JOIN AdoptionRequest ON Pet.id=AdoptionRequest.pet
    WHERE AdoptionRequest.user=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}

/**
 * Get a user's adoption requests for his pets.
 *
 * @param string $username  User's username
 * @return array            Array of adoption requests 
 */
function getAdoptionRequestsOfUserPets(string $username) : array {
    global $db;

    $stmt = $db->prepare('SELECT
    Pet.id,
    Pet.name,
    Pet.status,
    AdoptionRequest.id AS requestId,
    AdoptionRequest.text,
    AdoptionRequest.outcome,
    AdoptionRequest.user,
    AdoptionRequest.requestDate
    FROM Pet INNER JOIN AdoptionRequest ON Pet.id=AdoptionRequest.pet
    WHERE AdoptionRequest.pet IN (SELECT id FROM Pet WHERE Pet.postedBy=:username)');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}

/**
 * Change adoption request outcome
 *
 * @param int $reqId
 * @param string $outcome  Adoption Request outcome
 *
 * @return bool            True if successful, false otherwise.
 */
function changeAdoptionRequestOutcome(int $reqId, string $outcome) : bool {
    global $db;
    
    $stmt = $db->prepare('UPDATE
    AdoptionRequest SET outcome=:outcome WHERE id=:reqId'); 
    $stmt->bindParam(':outcome', $outcome);
    $stmt->bindParam(':reqId', $reqId);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

/**
 * Have the user requested the pet?
 *
 * @param string $username  User's username
 * @param int $petId        Pet's ID
 * @return bool             Have the user requested the pet?
 */
function userRequestedPet(string $username, int $petId) : bool {
    $adoption_requests = getAdoptionRequests($username);
    foreach ($adoption_requests as $request) {
        if ($request['id'] == $petId) return true;
    }
    
    return false;
}

/**
 * Get the adoption request outcome.
 *
 * @param string $username    User's username
 * @param string $petId       Pet's ID
 * @return ?string            Outcome of the adoption request made by the user to the pet, or null if there is none
 */
function getAdoptionRequestOutcome(string $username, string $petId) : ?string {
    global $db;
    $stmt = $db->prepare('SELECT outcome FROM AdoptionRequest
    WHERE user=:username AND pet=:petId ORDER BY requestDate DESC');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':petId', $petId);
    $stmt->execute();
    $request = $stmt->fetchAll();
    return $request[0]['outcome'];
}

/**
 * Add adoption request
 *
 * @param string $username  Username of user that created request
 * @param integer $id       ID of pet the adoption request refers to
 * @param string $text      Text of the adoption request
 *
 * @return string ID of the adoption request
 */
function addAdoptionRequest(string $username, int $id, string $text) : string {
    global $db;
    $stmt = $db->prepare('INSERT INTO AdoptionRequest
    (user, pet, text)
    VALUES
    (:user, :pet, :text)');
    $stmt->bindParam(':user'       , $username   );
    $stmt->bindParam(':pet'        , $id         );
    $stmt->bindParam(':text'       , $text       );
    $stmt->execute();
    return $db->lastInsertId();
}

/**
 * Withdraw adoption Request.
 * 
 * @param string $username User's username
 * @param integer $petId   Pet's Id
 * @return boolean         True if withdraw was successful, false otherwise
 */
function withdrawAdoptionRequest(string $username, int $petId): bool {
    global $db;

    $stmt = $db->prepare('DELETE FROM AdoptionRequest
                            WHERE user=:username AND pet=:petId');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':petId', $petId);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

/**
 * Refuses other proposals made to the pet, because the pet was adopted.
 * 
 * @param integer $requestId    Request Id
 * @param integer $petId        Pet's Id
 * @return void
 */
function refuseOtherProposals(int $requestId, int $petId) {
    $adoption_requests = getAdoptionRequestsOfUserPets($petId);
    foreach ($adoption_requests as $request)
        if ($request['requestId'] != $requestId) {
            changeAdoptionRequestOutcome($requestId, "rejected");
            changePetStatus($petId, "adopted");
        }
}

/**
 * Get the user's adopted pets.
 *
 * @param string $username  User's username
 * @return array            Array of adopted pets
 */
function getPetsAdoptedByUser(string $username) : array {
    global $db;
    $stmt = $db->prepare('SELECT
    Pet.id,
    Pet.name,
    Pet.species,
    Pet.age,
    Pet.sex,
    Pet.size,
    Pet.color,
    Pet.location,
    Pet.description,
    Pet.status,
    Pet.adoptionDate,
    Pet.postedBy
    FROM Pet INNER JOIN AdoptionRequest ON Pet.id=AdoptionRequest.pet
    WHERE AdoptionRequest.user=:username
    AND Pet.status="adopted" AND AdoptionRequest.outcome="accepted"');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}
