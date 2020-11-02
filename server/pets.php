<?php

/**
 * Get array of all pets.
 *
 * @return array    Array of all pets
 */
function getPets() : array {
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Pet');
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}

/**
 * Add new pet to database.
 *
 * @param string $name          Pet name
 * @param string $species       Species
 * @param float $age            Age (in years; 0.5 for 6 months, for instance)
 * @param string $sex           'M' or 'F'
 * @param string $size          XS, S, M, L, XL
 * @param string $color         Color (as a string)
 * @param string $location      Location
 * @param string $description   Description
 * @param string $postedBy      User that posted the pet
 * @return integer              ID of the new pet
 */
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
) : int {
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
    return $db->lastInsertId();
}

/**
 * Get pet information.
 *
 * @param integer $id   ID of pet
 * @return array        Array of named indexes containing pet information
 */
function getPet(int $id) : array {
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Pet
    WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pet = $stmt->fetch();
    return $pet;
}

/**
 * Edit pet.
 *
 * @param integer $id           Pet ID
 * @param string $name          Pet name
 * @param string $species       Species
 * @param float $age            Age
 * @param string $sex           M/F
 * @param string $size          XS, S, M, L, XL
 * @param string $color         Color
 * @param string $location      Location
 * @param string $description   Description
 * @return void
 */
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

/**
 * Remove pet.
 *
 * @param integer $id       ID of pet to be removed
 * @return void
 */
function removePet(int $id){
    deletePetPhotoFiles($id);

    global $db;
    $stmt = $db->prepare('DELETE FROM Pet
    WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

/**
 * Delete photo files associated to a pet.
 *
 * @param integer $id   Pet ID
 * @return void
 */
function deletePetPhotoFiles(int $id){
    global $db;
    $stmt = $db->prepare('SELECT url FROM PetPhoto
    WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $urls = $stmt->fetchAll();
    foreach($urls as $url){
        deletePetPhotoFile($url);
    }
}

/**
 * Delete pet photo from URL.
 *
 * @param string $url   URL of photo to delete
 * @return void
 */
function deletePetPhotoFile(string $url){
    $path = urlToFilepath($url);
    if(!unlink($path)){
        throw new Error("failed to unlink ".$path);
    }
}

/**
 * Convert URL to server filepath.
 * 
 * TODO: NOT IMPLEMENTED
 *
 * @param string $url   URL
 * @return string       File path
 */
function urlToFilepath(string $url) : string {
    throw new BadFunctionCallException("deletePetPhotoFile is not implemented");
}

/**
 * Get pet main photo
 *
 * @param integer $id   Pet ID
 * @return string       URL of pet main photo
 */
function getPetMainPhoto(int $id) : string {
    global $db;
    $stmt = $db->prepare('SELECT id, url FROM PetPhoto
    WHERE petId=:petId');
    $stmt->bindParam(':petId', $id);
    $stmt->execute();
    $urls = $stmt->fetchAll();

    if(count($urls) == 0) return '';

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

/**
 * Get comments about a pet.
 *
 * @param integer $id   ID of the pet
 * @return array        Array of comments about that pet
 */
function getPetComments(int $id) : array {
    global $db;
    $stmt = $db->prepare('SELECT *
    FROM Comment
    WHERE pet=:id');
    $stmt->bindParam(':id', $id);;
    $comments = $stmt->fetchAll();
    return $comments;
}

/**
 * Adds comment about pet.
 *
 * @param integer $id       ID of pet
 * @param string $username  User's username
 * @param int $answerTo     ID of comment it is replying to
 * @param string $text      Text of the comment
 * @param array $photosUrls URLs of the comment photos
 * @return integer          ID of the new comment
 */
function addPetComment(int $id, string $username, int $answerTo, string $text, array $photosUrls) : int {
    global $db;
    
    $stmt = $db->prepare('INSERT INTO Comment
    (pet, user, answerTo, text)
    VALUES
    (:pet, :user, :answerTo, :text)');
    $stmt->bindParam(':pet'        , $id         );
    $stmt->bindParam(':user'       , $username   );
    $stmt->bindParam(':answerTo'   , $answerTo   );
    $stmt->bindParam(':text'       , $text       );
    $stmt->execute();
    $commentId = $db->lastInsertId();

    foreach($photosUrls as $url){
        $stmt = $db->prepare('INSERT INTO CommentPhoto(commentId, url) VALUES
        (:commentId, :url)');
        $stmt->bindParam(':commentId', $commentId);
        $stmt->bindParam(':url'      , $url      );
        $stmt->execute();
    }

    return $commentId;
}

/**
 * Get photos associated to comments about a pet.
 *
 * @param integer $id   ID of the pet
 * @return array        Array of photos in comments about a pet
 */
function getPetCommentsPhotos(int $id) : array {
    global $db;
    $stmt = $db->prepare('SELECT * FROM CommentPhoto 
    WHERE commentId IN (SELECT id FROM Comment WHERE id=:id)');
    $stmt->bindParam(':id', $id);;
    $comments = $stmt->fetchAll();
    return $comments;
}

/**
 * Get pets added by a user.
 *
 * @param string $username  User's username
 * @return array            Array of pets added by that user
 */
function getAddedPets(string $username) : array {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Pet 
    WHERE postedBy=:username');
    $stmt->bindParam(':username', $username);;
    $addedPets = $stmt->fetchAll();
    return $addedPets;
}

/**
 * Add adoption request
 *
 * @param string $username  Username of user that created request
 * @param integer $id       ID of pet the adoption request refers to
 * @param string $text      Text of the adoption request
 * @return integer          ID of the adoption request
 */
function addAdoptionRequest(string $username, int $id, string $text) : int {
    global $db;
    $stmt = $db->prepare('INSERT INTO AdoptionRequest
    (user, pet, text)
    VALUES
    (:user, :pet, :text)');
    $stmt->bindParam(':user'       , $username   );
    $stmt->bindParam(':pet'        , $id         );
    $stmt->bindParam(':text'       , $text       );
    $stmt->execute();
    return $db->lastInsertId();
}

/**
 * Withdraw adoption Request.
 * 
 * @param string $username User's username
 * @param integer $petId   Pet's Id
 * @return boolean         True if withdraw was successful, false otherwise
 */
function withdrawAdoptionRequest(string $username, int $petId): bool {
    global $db;

    $stmt = $db->prepare('DELETE FROM AdoptionRequest
                            WHERE user=:username AND pet=:petId');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':petId', $petId);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

?>
