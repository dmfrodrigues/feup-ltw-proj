<?php

function userExists(string $username, string $password){
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

function getUser(string $username){
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM User
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    return $user;
}

function isAdmin(string $username){
    global $db;
    $stmt = $db->prepare('SELECT username
    FROM Admin
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admins = $stmt->fetchAll();
    return (count($admins) == 1);
}

function editUser(string $username, string $password, string $name){
    global $db;
    $password_sha1 = sha1($password);
    $stmt = $db->prepare('UPDATE User SET
    username=:username,
    password=:password,
    name=:name
    WHERE username=:username');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_sha1);
    $stmt->bindParam(':name'    , $name);
    $stmt->execute();
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
function removeFromFavorites(string $username, int $id) : bool {
    global $db;
    $stmt = $db->prepare('DELETE FROM FavoritePet WHERE
    username=:username AND petId=:id)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id'      , $id      );
    $stmt->execute();
}
