<?php
function getPets(){
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Pet');
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}

function getFavoritePets(string $username){
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

function addPet(
    string $name,
    string $species,
    float  $age,
    string $sex,
    string $size,
    string $color,
    string $location,
    string $description,
    string $postedBy
){
    global $db;
    $stmt = $db->prepare('INSERT INTO Pet
    (name, species, age, sex, size, color, location, description, postedBy)
    VALUES
    (:name, :species, :age, :sex, :size, :color, :location, :description, :postedBy)');
    $stmt->bindParam(':name'       , $name       );
    $stmt->bindParam(':species'    , $species    );
    $stmt->bindParam(':age'        , $age        );
    $stmt->bindParam(':sex'        , $sex        );
    $stmt->bindParam(':size'       , $size       );
    $stmt->bindParam(':color'      , $color      );
    $stmt->bindParam(':location'   , $location   );
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':postedBy'   , $postedBy   );
    $stmt->execute();
    $stmt->fetch();
    return $db->lastInsertId();
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

function editPet(
    int $id,
    string $name,
    string $species,
    float  $age,
    string $sex,
    string $size,
    string $color,
    string $location,
    string $description
){
    global $db;
    $stmt = $db->prepare('UPDATE Pet SET
    name=:name,
    species=:species,
    age=:age,
    sex=:sex,
    size=:size,
    color=:color,
    location=:location,
    description=:description
    WHERE id=:id');
    $stmt->bindParam(':id'         , $id         );
    $stmt->bindParam(':name'       , $name       );
    $stmt->bindParam(':species'    , $species    );
    $stmt->bindParam(':age'        , $age        );
    $stmt->bindParam(':sex'        , $sex        );
    $stmt->bindParam(':size'       , $size       );
    $stmt->bindParam(':color'      , $color      );
    $stmt->bindParam(':location'   , $location   );
    $stmt->bindParam(':description', $description);
    $stmt->execute();
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
