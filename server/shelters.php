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