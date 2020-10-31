<?php
function getPets(){
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Pet');
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return (count($pets) == 1);
}

function getPet(int $id){
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Pet
    WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pet = $stmt->fetch();
    return (count($pet) == 1);
}

function getPetComments(int $id){
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Comment
    WHERE pet=:id');
    $stmt->bindParam(':id', $id);;
    $comments = $stmt->fetchAll();
    return $comments;
}

function getPetCommentsPhotos(int $id){
    global $db;
    $stmt = $db->prepare('SELECT * FROM PetPhotoInComment 
    WHERE commentId IN (SELECT id FROM Comment WHERE id=:id)');
    $stmt->bindParam(':id', $id);;
    $comments = $stmt->fetchAll();
    return $comments;
}
