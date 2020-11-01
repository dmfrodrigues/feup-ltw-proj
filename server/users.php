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
    return $stmt->execute();
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
    return $stmt->execute();
}
