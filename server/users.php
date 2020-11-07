<?php

include_once __DIR__.'/server.php';
include_once SERVER_DIR.'/files.php';

define('USERS_IMAGES_DIR', SERVER_DIR.'/resources/img/profiles');

class CouldNotDeleteFileException extends RuntimeException{}

/**
 * Check if user-password pair is valid.
 *
 * @param string $username  Username
 * @param string $password  Password
 * @return boolean          True if the user-password pair is correct, false otherwise
 */
function userExists(string $username, string $password) : bool {
    global $db;
    $password_sha1 = sha1($password);
    $stmt = $db->prepare('SELECT username
    FROM User
    WHERE username=:username AND password=:password');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_sha1);
    $stmt->execute();
    $users = $stmt->fetchAll();
    return (count($users) == 1);
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
    global $db;
    $password_sha1 = sha1($password);
    $stmt = $db->prepare('INSERT INTO User(username, password, name) VALUES
    (:username, :password, :name)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_sha1);
    $stmt->bindParam(':name'    , $name);
    $stmt->execute();
}

/**
 * Get user data.
 *
 * @param string $username      User's username
 * @return array                Array of user data fields
 */
function getUser(string $username) : array {
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM User
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    $user['pictureUrl'] = getUserPicture($username);
    return $user;
}

/**
 * Get user profile picture URL.
 *
 * @param string $username  Username
 * @return ?string           URL of user profile picture, or null if there is none
 */
function getUserPicture(string $username) : ?string {
    $url = "../server/resources/img/profiles/$username.jpg";
    if(!file_exists($url)) $url = null;
    return $url;
}

/**
 * Check if user is admin.
 *
 * @param string $username  User's username
 * @return boolean          True if user is admin, false otherwise
 */
function isAdmin(string $username) : bool {
    global $db;
    $stmt = $db->prepare('SELECT username
    FROM Admin
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admins = $stmt->fetchAll();
    return (count($admins) == 1);
}

/**
 * Edit user name.
 *
 * @param string $lastUsername  User's last username
 * @param string $newUsername   User's new username
 * @param string $name          User's name
 * @return void
 */
function editUser(string $lastUsername, string $newUsername, string $name){
    global $db;
    $stmt = $db->prepare('UPDATE User SET
    username=:newUsername,
    name=:name
    WHERE username=:lastUsername');
    $stmt->bindParam(':newUsername', $newUsername);
    $stmt->bindParam(':lastUsername', $lastUsername);
    $stmt->bindParam(':name'    , $name);
    $stmt->execute();
}


/**

 * Edit user password.
 *
 * @param string $username  User's username
 * @param string $password  User's password
 * @return void
 */
function editUserPassword(string $username, string $password) {
    global $db;
    $password_sha1 = sha1($password);
    $stmt = $db->prepare('UPDATE User SET
    password=:password
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_sha1);
    $stmt->execute();
}

/**

 * Delete user.
 *
 * @param string $username  User's username
 * @return void
 */
function deleteUser(string $username) {
    global $db;
    eraseUserPicture($username);
    $stmt = $db->prepare('DELETE FROM User 
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
}

/**
 * Save new user picture.
 *
 * @param string $username  User's username
 * @param array $file       File (as obtained from $_FILES['file_field'])
 * @return void
 */
function saveUserPicture(string $username, array $file){
    $ext = checkImageFile($file, 1000000);

    $filepath = USERS_IMAGES_DIR."/$username.jpg";
    convertImage(
        $file['tmp_name'],
        $ext,
        $filepath,
        85
    );
}

/**
 * Erase user picture.
 *
 * @param string $username  User's username
 * @return void
 */
function eraseUserPicture(string $username){
    $filepath = USERS_IMAGES_DIR."/$username.jpg";
    if(!unlink($filepath))
        throw new CouldNotDeleteFileException("Could not delete '$filepath'");
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
    $favoritePets = getFavoritePets($username);
    foreach ($favoritePets as $pet)
        if ($pet['id'] == $id)
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
    Pet.postedBy
    FROM Pet INNER JOIN FavoritePet ON Pet.id=FavoritePet.petId
    WHERE FavoritePet.username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
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
    AdoptionRequest.text,
    AdoptionRequest.outcome
    FROM Pet INNER JOIN AdoptionRequest ON Pet.id=AdoptionRequest.pet
    WHERE AdoptionRequest.user=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}

