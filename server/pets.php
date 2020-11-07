<?php

include_once __DIR__.'/server.php';
include_once SERVER_DIR.'/users.php';

define('PETS_IMAGES_DIR', SERVER_DIR.'/resources/img/pets');
define('COMMENTS_IMAGES_DIR', SERVER_DIR . '/resources/img/comments');

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
    $id = $db->lastInsertId();

    // Create images folder
    $path = PETS_IMAGES_DIR."/$id";
    mkdir($path);

    return $id;
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
    rmdir_recursive(PETS_IMAGES_DIR."/$id");

    global $db;
    $stmt = $db->prepare('DELETE FROM Pet
    WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

define('IMAGES_EXTENSIONS', ['jpg']);

/**
 * Delete photo files associated to a pet.
 *
 * @param integer $id   Pet ID
 * @return void
 */
function deletePetPhotos(int $id){
    $dir = PETS_IMAGES_DIR."/$id";
    $lst = scandir($dir);
    foreach($lst as $name){
        if($name === '.' || $name === '..') continue;
        $path = "$dir/$name";
        rmdir_recursive($path);
    }
    rmdir_recursive($path);
}

/**
 * Add pet photo
 *
 * @param integer $id           ID of pet
 * @param string $tmp_filepath  File path to temporary file
 * @param integer $idx          Index of image (1 is the first image); should be numbered sequentially
 * @return void
 */
function addPetPhoto(int $id, string $tmp_filepath, int $idx){
    $filepath = PETS_IMAGES_DIR."/$id/".str_pad($idx, 3, '0', STR_PAD_LEFT).".jpg";
    if(!move_uploaded_file($tmp_filepath, $filepath))
        throw new RuntimeException('Failed to move uploaded file.');
}

/**
 * Get pet main photo
 *
 * @param integer $id   Pet ID
 * @return string       URL of pet main photo
 */
function getPetMainPhoto(int $id) : string {
    $dir = PETS_IMAGES_DIR."/$id";
    if(!is_dir($dir)) return 'resources/img/no-image.svg';
    
    $lst = scandir($dir);
    foreach($lst as $filename){
        $filepath = "$dir/$filename";
        if(in_array(pathinfo($filepath)['extension'], IMAGES_EXTENSIONS)){
            $url = serverpathToUrl($filepath);
            return $url;
        }
    }

    return 'resources/img/no-image.svg';
}

/**
 * Get pet photos
 *
 * @param integer $id   Pet ID
 * @return array       Pet photos
 */
function getPetPhotos(int $id) : array {
    $dir = PETS_IMAGES_DIR."/$id";
    $photos = array();
    if(!is_dir($dir)) return $photos;
    
    $lst = scandir($dir);
    foreach($lst as $filename){
        $filepath = "$dir/$filename";
        if(in_array(pathinfo($filepath)['extension'], IMAGES_EXTENSIONS)){
            $url = serverpathToUrl($filepath);
            array_push($photos, $url);
        }
    }

    return $photos;
}

/**
 * Get comments about a pet.
 *
 * @param integer $id   ID of the pet
 * @return array        Array of comments about that pet
 */
function getPetComments(int $id) : array {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Comment WHERE pet=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $comments = $stmt->fetchAll();
    for($i = 0; $i < count($comments); ++$i){
        $comments[$i]['userPictureUrl'] = getUserPicture($comments[$i]['user']);
        $comments[$i]['commentPictureUrl'] = getCommentPicture($comments[$i]['id']);
    }
    return $comments;
}

/**
 * Get comment about a pet.
 *
 * @param integer $commentId    ID of comment
 * @return array                Comment
 */
function getPetComment(int $commentId) : array {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Comment WHERE id=:id');
    $stmt->bindParam(':id', $commentId);
    $stmt->execute();
    $comment = $stmt->fetch();
    $comment['userPictureUrl'   ] = getUserPicture   ($comment['user']);
    $comment['commentPictureUrl'] = getCommentPicture($comment['id'  ]);
    return $comment;
}

/**
 * Adds comment about pet.
 *
 * @param integer $id       ID of pet
 * @param string $username  User's username
 * @param ?int $answerTo    ID of comment it is replying to, or null if not a reply
 * @param string $text      Text of the comment
 * @param array $file       File (as obtained from $_FILES['file_field'])
 * @return integer          ID of the new comment
 */
function addPetComment(int $id, string $username, ?int $answerTo, string $text, array $file) : int {
    $noFileSent = false;
    try{
        $ext = checkImageFile($file, 1000000);
    } catch(NoFileSentException $e){
        $noFileSent = true;
    }
    if($text === '' && $noFileSent) throw new RuntimeException('Comment must have a text or an image');

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

    if(!$noFileSent){
        $filepath = COMMENTS_IMAGES_DIR . "/$commentId.jpg";
        convertImage(
            $file['tmp_name'],
            $ext,
            $filepath,
            85
        );
    }

    return $commentId;
}

/**
 * Get photos associated to comments about a pet.
 *
 * @param integer $id   ID of the comment
 * @return string        URL of comment photo
 */
function getCommentPicture(int $id) : string {
    $url = "../server/resources/img/comments/$id.jpg";
    if(!file_exists($url)) $url = '';
    return $url;
}

/**
 * Delete comment photo.
 *
 * @param integer $commentId    ID of comment
 * @return void
 */
function deletePetCommentPhoto(int $commentId){
    $filepath = COMMENTS_IMAGES_DIR . "/$commentId.jpg";
    if(!unlink($filepath))
        throw new CouldNotDeleteFileException("Could not delete '$filepath'");
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
    $stmt->bindParam(':username', $username);
    $stmt->execute();
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
