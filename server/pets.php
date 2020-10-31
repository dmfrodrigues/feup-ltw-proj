<?php
function getPets(){
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Pet');
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}

function getPet(int $id){
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Pet
    WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pet = $stmt->fetch();
    return $pet;
}

function getPetMainPhoto(int $id){
    global $db;
    $stmt = $db->prepare('SELECT id, url FROM PetPhoto
    WHERE petId=:petId');
    $stmt->bindParam(':petId', $id);
    $stmt->execute();
    $urls = $stmt->fetchAll();

    $id = $urls[0]['id'];
    $url_ret = $urls[0]['url'];
    foreach($urls as $url){
        if($url['id'] < $id){
            $id = $url['id'];
            $url_ret = $url['url'];
        }
    }
    
    return $url_ret;
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
