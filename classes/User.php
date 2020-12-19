<?php

require_once __DIR__.'/../server.php';
require_once SERVER_DIR.'/files.php';
require_once SERVER_DIR.'/rest/authentication.php';
require_once SERVER_DIR.'/classes/Pet.php';

define('USERS_IMAGES_DIR', SERVER_DIR.'/resources/img/profiles');

use function Authentication\noHTML;

class UserAlreadyExistsException extends RuntimeException{}
class InvalidUsernameException extends RuntimeException{}

class User implements JsonSerializable {
    private  string $username;
    private  string $password;
    private  string $email;
    private  string $name;
    private  string $registeredOn;
    private ?string $shelter;
    // private  bool   $admin;
    public function __construct(){}

    public function getUsername    () :  string { return noHTML($this->username)     ; }
    public function getPassword    () :  string { return noHTML($this->password)     ; }
    public function getEmail       () :  string { return noHTML($this->email)        ; }
    public function getName        () :  string { return noHTML($this->name)         ; }
    public function getRegisteredOn() :  string { return $this->registeredOn         ; }
    /**
     * @return Shelter|null
     */
    public function getShelter() {
        return ($this->shelter == null ?
            null :
            (Shelter::fromDatabase($this->shelter))
        );
    }
    public function getShelterId() : ?string { return noHTML($this->shelter); }
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

    public function setUsername    ( string $username    ) : void {
        if(!preg_match('/^[a-zA-Z0-9]+$/', $username)){
            throw new InvalidArgumentException("username ('{$username}') should contain at least a character, and be made of numbers or letters only");
        }
        $this->username = $username;
    }
    public function setPassword    ( string $password, bool $hashed = true) : void {
        if(!preg_match('/^(?=.*[!@#$%^&*)(+=._-])(?=.*[A-Z])(?=.{7,}).*$/', $password)) 
            throw new InvalidArgumentException("Password needs be at least 7 characters long 
            and contain at least one uppercase letter and 1 special character");
        $this->password = ($hashed?
            $password :
            (User::hashPassword($password))
        );
    }
    public function setName ( string $name ) : void { 
        $newName = filter_var($name, FILTER_SANITIZE_STRING);
        $this->name = $newName; 
    }
    public function setEmail(string $email) : void {
        $newEmail = filter_var($email, FILTER_SANITIZE_STRING);
        $this->email = $newEmail;
    }
    public function setRegisteredOn( string $registeredOn) : void { $this->registeredOn = $registeredOn; }
    public function setShelter     (?string $shelter     ) : void {
        $newShelter = filter_var($shelter, FILTER_SANITIZE_STRING);
        $this->shelter = $newShelter ; 
    }
    /**
     * Save new user picture.
     *
     * @param string $tmpFilePath  Temporary file path (after uploading to user/photo
     */
    public function setPicture(string $tmpFilePath) : void {
        $ext = checkImageFile($tmpFilePath, USER_PICTURE_MAX_SIZE);

        $filepath = USERS_IMAGES_DIR."/{$this->username}.jpg";
        convertImage(
            $tmpFilePath,
            $ext,
            $filepath,
            85
        );
    }

    public function jsonSerialize() {
        $ret = get_object_vars($this);
        unset($ret['password']);
        $ret['pictureUrl'] = $this->getPictureUrl();
        return $ret;
    }

    static public function hashPassword(string $password) : string {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    /**
     * Get users that can join a shelter.
     *
     * @return array            Array containing all the the users that can join a shelter.
     */
    static public function allWithoutShelter() : array {
        global $db;

        $stmt = $db->prepare('SELECT * FROM User
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

        if (User::exists($this->username))
            throw new UserAlreadyExistsException("The username ".$this->username." already exists! Please choose another one!");

        $stmt = $db->prepare('INSERT INTO User(username, password, email, name) VALUES
        (:username, :password, :email, :name)');
        $stmt->bindValue(':username', $this->username);
        $stmt->bindValue(':password', $this->password);
        $stmt->bindValue(':email'   , $this->email);
        $stmt->bindValue(':name'    , $this->name);
        if(!$stmt->execute()) throw new RuntimeException();

        $newUser = User::fromDatabase($this->username);
        if($newUser == null) throw new RuntimeException();
        $this->setRegisteredOn($newUser->getRegisteredOn());
        $this->setShelter     ($newUser->getShelterId());
    }

    public function delete() : void {
        global $db;
        $user_pets = $this->getAddedPets();
        foreach($user_pets as $i => $pet){
            $id = $pet->getId();
            $dir = PETS_IMAGES_DIR."/$id";
            rmdir_recursive($dir);
        }
        deleteUserPhoto($this->username);
        $stmt = $db->prepare('DELETE FROM User WHERE username=:username');
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();
    }

    /**
     * Delete user.
     *
     * @param string $username  User's username
     * @return void
     */
    static public function deleteFromDatabase(string $username) : void {
        User::fromDatabase($username)->delete();
    }

    static public function fromDatabase(string $username) : ?User {
        global $db;
        $stmt = $db->prepare('SELECT * FROM User WHERE username=:username');
        $stmt->bindValue(':username', $username);
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
        $stmt->bindValue(':username'    , $this->username    );
        $stmt->bindValue(':password'    , $this->password    );
        $stmt->bindValue(':name'        , $this->name        );
        $stmt->bindValue(':registeredOn', $this->registeredOn);
        $stmt->bindValue(':shelter'     , $this->shelter     );
        $stmt->execute();
    }

    static public function changeUsernameInDatabase(string $oldUsername, string $newUsername): void{
        global $db;

        if($oldUsername != $newUsername)
            if (User::exists($newUsername))
                throw new UserAlreadyExistsException("The username ".$newUsername." already exists! Please choose another one!");
            
        $stmt = $db->prepare('UPDATE User SET
        username=:newUsername
        WHERE username=:oldUsername');
        $stmt->bindValue(':newUsername', $newUsername);
        $stmt->bindValue(':oldUsername', $oldUsername);
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
        $stmt = $db->prepare('SELECT username
        FROM User
        WHERE upper(username)=:username');
        $capitalUsername = strtoupper($username);
        $stmt->bindParam(':username', $capitalUsername);
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
        $stmt = $db->prepare('SELECT password
        FROM User
        WHERE username=:username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user !== false && password_verify($password, $user['password'])) 
            return true;
        return false;
    }

    public function getFavoritePets() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM PET
        WHERE id IN (
            SELECT petId FROM FavoritePet
            WHERE username=:username
        )');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }

    public function getAddedPets() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet 
        WHERE postedBy=:username');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->bindValue(':username', $this->username);
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
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }

    /**
     * Get pets added by a user that were adopted.
     *
     * @return array            Array of adopted pets added by that user
     */
    public function getPetsAdopted() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet 
        WHERE postedBy=:username
        AND status="adopted"');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }

    /**
     * Get adoption requests made by the user to other pets.
     *
     * @return array            Array of adoption requests 
     */
    public function getAdoptionRequestsToOthers() : array {
        global $db;

        $stmt = $db->prepare('SELECT * FROM AdoptionRequest
        WHERE user=:username');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'AdoptionRequest');
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();
        $requests = $stmt->fetchAll();

        return $requests;
    }

    /**
     * Get adoption requests made to my pets.
     *
     * @return array            Array of adoption requests 
     */
    public function getAdoptionRequestsToMe() : array {
        global $db;

        $stmt = $db->prepare('SELECT * FROM AdoptionRequest
        WHERE pet IN (
            SELECT id FROM Pet
            WHERE postedBy=:username
        )');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'AdoptionRequest');
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();
        $requests = $stmt->fetchAll();

        return $requests;
    }

    public function getPetsIAdopted() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet 
        WHERE status="adopted"
        AND id IN (
            SELECT pet FROM AdoptionRequest
            WHERE user=:username
            AND outcome="accepted"
        )');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->bindValue(':username', $this->username);
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }
}

class NoSuchUserException extends RuntimeException{}

require_once SERVER_DIR.'/classes/Shelter.php';

/**
 * Add user to database.
 *
 * @param string $username  User's username
 * @param string $password  Password
 * @param string $email     Email
 * @param string $name      Real name
 * @return void
 */
function addUser(string $username, string $password, string $email, string $name){

    if ($username === "new")
        throw new InvalidUsernameException("The username ".$username." is invalid! Please choose another one!");

    $user = new User();
    $user->setUsername($username);
    $user->setPassword($password, false);
    $user->setEmail   ($email);
    $user->setName    ($name);
    $user->addToDatabase();
}

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
    if($user == null) throw new NoSuchUserException($oldUsername);
    if ($newUsername === "new") throw new InvalidUsernameException("The username ".$newUsername." is invalid! Please choose another one!");
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
    if($user == null) throw new NoSuchUserException($username);
    $user->setPassword($password, false);
    $user->updateDatabase();
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
 * Get a user's favorite pets.
 *
 * @param string $username  User's username
 * @return array            Array of favorite pets of the user 
 */
function getFavoritePets(string $username) : array {
    $user = User::fromDatabase($username);
    if($user == null) throw new NoSuchUserException($username);
    return $user->getFavoritePets();
}

/**
 * Get users who favorite the pet.
 *
 * @param int $petId        Pet's ID
 * @return array            Array of users who favorite the pet
 */
function getUsersWhoFavoritePet(int $petId) : array {
    global $db;
    
    $stmt = $db->prepare('SELECT 
        User.username,
        User.name
        FROM User INNER JOIN FavoritePet ON User.username=FavoritePet.username
        WHERE FavoritePet.petId=:petId');
    $stmt->bindValue(':petId', $petId);
    $stmt->execute();
    $usersWhoFavoritePet = $stmt->fetchAll();
    return $usersWhoFavoritePet;
}
