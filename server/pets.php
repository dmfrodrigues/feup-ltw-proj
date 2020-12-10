<?php

include_once __DIR__.'/server.php';
include_once SERVER_DIR.'/users.php';

define('PETS_IMAGES_DIR', SERVER_DIR.'/resources/img/pets');
define('COMMENTS_IMAGES_DIR', SERVER_DIR . '/resources/img/comments');
define('COMMENT_PHOTO_MAX_SIZE', 1000000);

class Pet implements JsonSerializable {
    private ?int    $id          ;
    private  string $name        ;
    private  string $species     ;
    private  float  $age         ;
    private  string $sex         ;
    private  string $size        ;
    private  string $color       ;
    private  string $location    ;
    private  string $description ;
    private  string $status      ;
    private ?string $adoptionDate;
    private  string $postedBy    ;
    public function __construct(
        ?int    $id           = null,
         string $name         = '',
         string $species      = '',
         float  $age          = -1,
         string $sex          = '',
         string $size         = '',
         string $color        = '',
         string $location     = '',
         string $description  = '',
         string $status       = '',
        ?string $adoptionDate = null,
         string $postedBy     = ''
    ){
        $this->id           = $id          ;
        $this->name         = $name        ;
        $this->species      = $species     ;
        $this->age          = $age         ;
        $this->sex          = $sex         ;
        $this->size         = $size        ;
        $this->color        = $color       ;
        $this->location     = $location    ;
        $this->description  = $description ;
        $this->status       = $status      ;
        $this->adoptionDate = $adoptionDate;
        $this->postedBy     = $postedBy    ;
    }

    public function getId          () : ?int    { return $this->id          ; }
    public function getName        () :  string { return $this->name        ; }
    public function getSpecies     () :  string { return $this->species     ; }
    public function getAge         () :  float  { return $this->age         ; }
    public function getSex         () :  string { return $this->sex         ; }
    public function getSize        () :  string { return $this->size        ; }
    public function getColor       () :  string { return $this->color       ; }
    public function getLocation    () :  string { return $this->location    ; }
    public function getDescription () :  string { return $this->description ; }
    public function getStatus      () :  string { return $this->status      ; }
    public function getAdoptionDate() : ?string { return $this->adoptionDate; }
    public function getPostedBy    (bool $raw = false) { 
        if($raw) return $this->postedBy;
        else     return User::fromDatabase($this->postedBy);
    }
    public function getAuthor      (bool $raw = false) {
        if($raw) return $this->postedBy;
        else     return $this->getPostedBy();
    }

    public function setId          ( int    $id          ) : void { $this->id           = $id          ; }
    public function setName        ( string $name        ) : void { $this->name         = $name        ; }
    public function setSpecies     ( string $species     ) : void { $this->species      = $species     ; }
    public function setAge         ( float  $age         ) : void { $this->age          = $age         ; }
    public function setSex         ( string $sex         ) : void { $this->sex          = $sex         ; }
    public function setSize        ( string $size        ) : void { $this->size         = $size        ; }
    public function setColor       ( string $color       ) : void { $this->color        = $color       ; }
    public function setLocation    ( string $location    ) : void { $this->location     = $location    ; }
    public function setDescription ( string $description ) : void { $this->description  = $description ; }
    public function setStatus      ( string $status      ) : void { $this->status       = $status      ; }
    public function setAdoptionDate(?string $adoptionDate) : void { $this->adoptionDate = $adoptionDate; }
    public function setPostedBy    ( string $postedBy    ) : void { $this->postedBy     = $postedBy    ; }
    public function setAuthor      ( string $author      ) : void { $this->setPostedBy($author)        ; }

    public function jsonSerialize() {
		return get_object_vars($this);
    }
    
    public function addToDatabase(){
        global $db;
        $stmt = $db->prepare('INSERT INTO Pet
        (name, species, age, sex, size, color, location, description, postedBy)
        VALUES
        (:name, :species, :age, :sex, :size, :color, :location, :description, :postedBy)');
        $stmt->bindParam(':name'       , $this->name       );
        $stmt->bindParam(':species'    , $this->species    );
        $stmt->bindParam(':age'        , $this->age        );
        $stmt->bindParam(':sex'        , $this->sex        );
        $stmt->bindParam(':size'       , $this->size       );
        $stmt->bindParam(':color'      , $this->color      );
        $stmt->bindParam(':location'   , $this->location   );
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':postedBy'   , $this->postedBy   );
        $stmt->execute();
        $this->id = $db->lastInsertId();
        
        $newPet = Pet::fromDatabase($this->id);
        $this->setStatus      ($newPet->getStatus      ());
        $this->setAdoptionDate($newPet->getAdoptionDate());
    }

    static public function fromDatabase(int $id) : Pet {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet WHERE id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->execute();
        $pet = $stmt->fetch();
        if($pet == false) throw new RuntimeException("No such pet");
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
    static public function edit(
        int $id,
        string $name,
        string $species,
        float  $age,
        string $sex,
        string $size,
        string $color,
        string $location,
        string $description,
        array  $pictures
    ){
        $pet = Pet::fromDatabase($id);
        $pet->setName       ($name       );
        $pet->setSpecies    ($species    );
        $pet->setAge        ($age        );
        $pet->setSex        ($sex        );
        $pet->setSize       ($size       );
        $pet->setColor      ($color      );
        $pet->setLocation   ($location   );
        $pet->setDescription($description);
        $pet->updateDatabase();

        editPetPictures($id, $pictures);
    }

    public function updateDatabase() : bool {
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
        $stmt->bindParam(':id'         , $this->id         );
        $stmt->bindParam(':name'       , $this->name       );
        $stmt->bindParam(':species'    , $this->species    );
        $stmt->bindParam(':age'        , $this->age        );
        $stmt->bindParam(':sex'        , $this->sex        );
        $stmt->bindParam(':size'       , $this->size       );
        $stmt->bindParam(':color'      , $this->color      );
        $stmt->bindParam(':location'   , $this->location   );
        $stmt->bindParam(':description', $this->description);
        return $stmt->execute();
    }

    static public function deletefromDatabase(int $id) : bool {
        rmdir_recursive(PETS_IMAGES_DIR."/$id");

        global $db;
        $stmt = $db->prepare('DELETE FROM Pet
        WHERE id=:id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    /**
     * Get array of all pets listed for adoption.
     *
     * @return array    Array of all pets listed for adoption
     */
    static public function getListedForAdoption() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet WHERE status="forAdoption"');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }
}

class Comment {
    private int    $id      ;
    private string $postedOn;
    private string $text    ;
    private int    $pet     ;
    private string $user    ;
    private int    $answerTo;

    public function __construct(
        int    $id      ,
        string $postedOn,
        string $text    ,
        int    $pet     ,
        string $user    ,
        int    $answerTo
    ){
        $this->id       = $id      ;
        $this->postedOn = $postedOn;
        $this->text     = $text    ;
        $this->pet      = $pet     ;
        $this->user     = $user    ;
        $this->answerTo = $answerTo;
    }

    public function getAuthor() : User { return User::fromDatabase($this->user); }
}

class FavoritePet {
    private string $username;
    private int    $petId   ;

    public function __construct(
        string $username,
        int    $petId   
    ){
        $this->username = $username;
        $this->petId    = $petId   ;
    }

    public function getUser() : User { return User::fromDatabase($this->username); }
}

class AdoptionRequest {
    private  int    $id         ;
    private  string $text       ;
    private  string $outcome    ;
    private  int    $pet        ;
    private  string $user       ;
    private  string $requestDate;

    public function __construct(
        int    $id         ,
        string $text       ,
        string $outcome    ,
        int    $pet        ,
        string $user       ,
        string $requestDate
    ){
        $this->id          = $id         ;
        $this->text        = $text       ;
        $this->outcome     = $outcome    ;
        $this->pet         = $pet        ;
        $this->user        = $user       ;
        $this->requestDate = $requestDate;
    }

    public function getAuthor() : User { return User::fromDatabase($this->user); }
    public function getPet   () : Pet  { return Pet ::fromDatabase($this->pet ); }

    static public function fromDatabase(string $id) : AdoptionRequest {
        global $db;
        $stmt = $db->prepare('SELECT * FROM AdoptionRequest WHERE id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'AdoptionRequest');
        $stmt->execute();
        $request = $stmt->fetch();
        return $request;
    }
}

class AdoptionRequestMessage {
    private  int    $id         ;
    private  string $text       ;
    private  int    $request    ;
    private  string $messageDate;
    private  string $user       ;
    public function __construct(
        int    $id         ,
        string $text       ,
        int    $request    ,
        string $messageDate,
        string $user       
    ){
        $this->id          = $id         ;
        $this->text        = $text       ;
        $this->request     = $request    ;
        $this->messageDate = $messageDate;
        $this->user        = $user       ;
    }

    public function getRequest() : AdoptionRequest { return AdoptionRequest::fromDatabase($this->request); }

    static public function fromDatabase(string $id) : AdoptionRequestMessage {
        global $db;
        $stmt = $db->prepare('SELECT * FROM AdoptionRequestMessage WHERE id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'AdoptionRequestMessage');
        $stmt->execute();
        $message = $stmt->fetch();
        return $message;
    }
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
    string $postedBy,
    array  $files
) : int {
    // Check if files are OK
    foreach($files as $id => $file) checkImageFile($file, 1000000);

    $pet = new Pet(
        null        ,
        $name       ,
        $species    ,
        $age        ,
        $sex        ,
        $size       ,
        $color      ,
        $location   ,
        $description,
        ''          ,
        null        ,
        $postedBy
    );
    $pet->addToDatabase();

    // Add images
    $path = PETS_IMAGES_DIR."/{$pet->getId()}";
    mkdir($path);

    foreach($files as $id => $file){
        $ext = checkImageFile($file, 1000000);
        $filepath = $path.'/'.str_pad($id, 3, '0', STR_PAD_LEFT).'.jpg';
        convertImage(
            $file['tmp_name'],
            $ext,
            $filepath,
            85
        );
    }

    return $pet->getId();
}

/**
 * Edit pet pictures.
 *
 * @param array $pictures   Pictures
 * @return void
 */
function editPetPictures(int $petId, array $pictures){
    $path = PETS_IMAGES_DIR."/$petId";
    
    $swappic = [];
    $newpic  = [];
    foreach($pictures as $key => $picture){
        if($picture['new']['tmp_name'] !== ''){ // new picture
            $newpic[$key] = $picture;
        } else if($picture['old'] !== ''){ //swap picture
            $swappic[$key] = $picture['old'];
        }
    }
    swapPetPictures($petId, $swappic);
    newPetPictures($petId, $newpic);

    $N = count($pictures);
    $images = scandir($path);
    foreach($images as $i => $filename){
        if($filename == '.' || $filename == '..') continue;
        $id = intval(explode('.', $filename)[0]);
        $filepath = "$path/$filename";
        if($id >= $N) unlink($filepath);
    }
}

/**
 * Swap pet pictures.
 *
 * @param integer $petId    Pet ID
 * @param array $swappic    Pictures to swap
 * @return void
 */
function swapPetPictures(int $petId, array $swappic){
    $path = PETS_IMAGES_DIR."/$petId";
    foreach($swappic as $newId => $oldId){
        $oldFilepath = $path.'/'    .str_pad(strval($oldId), 3, '0', STR_PAD_LEFT).'.jpg';
        $newFilepath = $path.'/new-'.str_pad(strval($newId), 3, '0', STR_PAD_LEFT).'.jpg';
        if(!rename($oldFilepath, $newFilepath)) throw new RuntimeException("Failed to rename pet picture $oldFilepath to $newFilepath");
    }
    foreach($swappic as $newId => $oldId){
        $tmpFilepath   = $path.'/new-'.str_pad(strval($newId), 3, '0', STR_PAD_LEFT).'.jpg';
        $finalFilepath = $path.'/'    .str_pad(strval($newId), 3, '0', STR_PAD_LEFT).'.jpg';
        if(!rename($tmpFilepath, $finalFilepath)) throw new RuntimeException("Failed to rename pet picture $tmpFilepath to $finalFilepath");
    }
}

/**
 * Add new pet pictures.
 *
 * @param integer $petId    Pet ID
 * @param array $newpic     Pictures to add
 * @return void
 */
function newPetPictures(int $petId, array $newpic){
    $path = PETS_IMAGES_DIR."/$petId";

    foreach($newpic as $id => $file){
        if($newpic[$id]['new']['size'] == 0) continue;
        $ext = checkEditImageFile($file, 1000000);
        $filepath = $path.'/'.str_pad($id, 3, '0', STR_PAD_LEFT).'.jpg';
        convertImage(
            $file['new']['tmp_name'],
            $ext,
            $filepath,
            85
        );
    }
}

define('IMAGES_EXTENSIONS', ['jpg']);

/**
 * Add pet photo
 *
 * @param integer $id           ID of pet
 * @param string $tmp_filepath  File path to temporary file
 * @param integer $idx          Index of image (1 is the first image); should be numbered sequentially
 * @return void
 */
function addPetPhoto(int $id, string $tmp_filepath, int $idx) {
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
            $url = path2url($filepath);
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
            $url = path2url($filepath);
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
function getPetComment(int $commentId) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Comment WHERE id=:id');
    $stmt->bindParam(':id', $commentId);
    $stmt->execute();
    $comment = $stmt->fetch();
    if(!$comment) return $comment;
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
 * @param array $file       Is file coming or not?
 * @return integer          ID of the new comment
 */
function addPetComment(int $id, string $username, ?int $answerTo, string $text, ?string $tmpFileId) : int {
    if($tmpFileId == null && $text == '')
        throw new RuntimeException('Comment must have a text or an image');

    if($tmpFileId != null){
        $tmpFilePath = sys_get_temp_dir().'/'.$tmpFileId;
        checkImageFile($tmpFilePath, COMMENT_PHOTO_MAX_SIZE);
    }

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
    $commentId = (int)$db->lastInsertId();

    if($tmpFileId != null){
        setCommentPhoto($commentId, $tmpFilePath);
    }

    return $commentId;
}

function setCommentPhoto(int $commentId, string $tmpFilePath) : void {
    $ext = checkImageFile($tmpFilePath, COMMENT_PHOTO_MAX_SIZE);
    $filepath = COMMENTS_IMAGES_DIR . "/$commentId.jpg";
    convertImage(
        $tmpFilePath,
        $ext,
        $filepath,
        85
    );
}

/**
 * Edits comment about pet.
 *
 * @param integer   $commentId      ID of comment
 * @param string    $text           Text of comment
 * @param string    $file           Picture file (as obtained from $_FILES['file_field'])
 * @return void
 */
function editPetComment(int $commentId, string $text, bool $deleteFile, ?string $file){
    $oldComment = getPetComment($commentId);

    $noFileSent = false;
    try{
        $ext = checkImageFile($file, 1000000);
    } catch(NoFileSentException $e){
        $noFileSent = true;
    }
    if($text === '' && $noFileSent && ($deleteFile || $oldComment['commentPictureUrl'] === ''))
        throw new RuntimeException('Comment must have a text or an image');

    global $db;
    
    $stmt = $db->prepare('UPDATE Comment SET
    text=:text
    WHERE id=:id');
    $stmt->bindParam(':text', $text     );
    $stmt->bindParam(':id'  , $commentId);
    $stmt->execute();
    
    if($deleteFile){
        deletePetCommentPhoto($commentId);
    }

    if(!$noFileSent){
        $filepath = COMMENTS_IMAGES_DIR . "/$commentId.jpg";
        convertImage(
            $file['tmp_name'],
            $ext,
            $filepath,
            85
        );
    }
}

/**
 * Delete pet comment.
 *
 * @param integer $id   Pet comment ID
 * @return void
 */
function deletePetComment(int $id){
    global $db;
    
    $stmt = $db->prepare('DELETE FROM Comment
    WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    deletePetCommentPhoto($id);
}

/**
 * Get photos associated to comments about a pet.
 *
 * @param integer $id    ID of the comment
 * @return string        URL of comment photo, or null if there is none
 */
function getCommentPicture(int $id) : ?string {
    $url = SERVER_DIR . "/resources/img/comments/$id.jpg";
    if(!file_exists($url)) return null;
    return path2url($url);
}

/**
 * Delete comment photo.
 *
 * @param integer $commentId    ID of comment
 * @return void
 */
function deletePetCommentPhoto(int $commentId){
    $filepath = COMMENTS_IMAGES_DIR . "/$commentId.jpg";
    if(file_exists($filepath))
        if(!unlink($filepath))
            throw new CouldNotDeleteFileException("Could not delete '$filepath'");
}

/**
 * Delete all the photos that are in the comments related to the pet.
 *
 * @param integer $id    ID of pet
 * @return void
 */
function deleteAllPetCommentPhotos(int $id){
    $comments = getPetComments($id);
    foreach($comments as $comment)
        if (getCommentPicture($comment['id']) !== '') // if the comment has a picture
            deletePetCommentPhoto($comment['id']);
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
 * Get pets added by a user that were not adopted yet.
 *
 * @param string $username  User's username
 * @return array            Array of pets added by that user
 */
function getAddedPetsNotAdopted(string $username) : array {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Pet 
    WHERE postedBy=:username AND status="forAdoption"');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $addedPets = $stmt->fetchAll();
    return $addedPets;
}


/**
 * Change pet status.
 * 
 * @param int $petId      Pet's Id
 * @param string $status  Pet status
 * @return boolean        True if withdraw was successful, false otherwise
 */
function changePetStatus(int $petId, string $status): bool {
    global $db;

    $stmt = $db->prepare('UPDATE Pet SET status=:status 
                            WHERE id=:petId');
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':petId', $petId);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

/**
 * Change pet status.
 * 
 * @param int $petId      Pet's Id
 * @return boolean        True if the pet was adopted, false otherwise.
 */
function checkIfAdopted(int $petId) : bool {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Pet 
    WHERE id=:petId AND status<>"forAdoption"');
    $stmt->bindParam(':petId', $petId);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

/**
 * Get a pet's adoption requests.
 *
 * @param string $petId     Pet's ID
 * @return array            Array of adoption requests
 */
function getPetAdoptionRequests(string $petId) : array {
    global $db;

    $stmt = $db->prepare('SELECT
    id,
    outcome,
    pet,
    user
    FROM AdoptionRequest
    WHERE pet=:petId');
    $stmt->bindParam(':petId', $petId);
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}

/**
 * Get adopted pets.
 * 
 * @return array            Array of adopted pets
 */
function getAdoptedPets() : array {
    global $db;
    $stmt = $db->prepare('SELECT * FROM Pet 
    WHERE status="adopted"');
    $stmt->execute();
    $addedPets = $stmt->fetchAll();
    return $addedPets;
}

/**
 * Get the user who adopted the given pet.
 *
 * @param string $id        Pet's ID
 * @return array            User who adopted the pet
 */
function getUserWhoAdoptedPet(int $id): array {
    global $db;
    $stmt = $db->prepare('SELECT
    User.username,
    User.name,
    User.shelter
    FROM AdoptionRequest INNER JOIN Pet ON Pet.id=AdoptionRequest.pet INNER JOIN User ON User.username=AdoptionRequest.user
    WHERE AdoptionRequest.outcome="accepted" AND Pet.status="adopted" AND AdoptionRequest.pet=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch();
    if (!$user) return [];
    return $user;
}

/**
 * Get the pets that were published by the user but were adopted.
 *
 * @param string $username      User's username
 * @return array                Array containing the pets.
 */
function getAdoptedPetsPublishedByUser($username) : array {
    
    $adoptedPets = getAdoptedPets();
    $adoptedPetsPublishedByUser = array();

    foreach($adoptedPets as $pet) {
        $user = getUserWhoAdoptedPet($pet->getId());
        if (!is_null($user) && $pet->getPostedBy() === $username)
            array_push($adoptedPetsPublishedByUser, $pet);
    }

    return $adoptedPetsPublishedByUser;
}  

