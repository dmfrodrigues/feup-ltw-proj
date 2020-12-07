<?php

include_once __DIR__.'/server.php';
include_once SERVER_DIR.'/users.php';
include_once __DIR__.'/pets.php';

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