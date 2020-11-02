<?php

include_once("../server/files.php");

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
    $user['pictureUrl'] = "../server/resources/img/profiles/".$username.".jpg";
    if(!file_exists($user['pictureUrl'])) $user['pictureUrl'] = "resources/img/no-image.svg";
    return $user;
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
 * Edit user name and username.
 *
 * @param string $username  User's username
 * @param string $name      User's name
 * @return void
 */
function editUser(string $username, string $name){
    global $db;
    $stmt = $db->prepare('UPDATE User SET
    username=:username,
    name=:name
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':name'    , $name);
    $stmt->execute();
}

/**

 * Edit user.
 *
 * @param string $password  User's password
 * @return void
 */
function editUserPassword(string $username, string $password) {
    global $db;
    $password_sha1 = sha1($password);
    $stmt = $db->prepare('UPDATE User SET
    password=:password
    WHERE username=:username');
    $stmt->bindParam(':username', $username     );
    $stmt->bindParam(':password', $password_sha1);
    $stmt->execute();

 * Save new user picture.
 *
 * @param string $username  User's username
 * @param array $file       File (as obtained from $_FILES['filefield'])
 * @return void
 */
function saveUserPicture(string $username, array $file){
    $ext = checkImageFile($file, 1000000);

    $uploaddir = '../server/resources/img/profiles';
    $uploadfile = $uploaddir."/".$username.".".$ext;
    if (!move_uploaded_file($file['tmp_name'], $uploadfile)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
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
    username=:username AND petId=:id)');
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
    $pet = $stmt->fetch();
    return $pet;
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
