<?php

require_once __DIR__.'/server.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Comment.php';
require_once SERVER_DIR.'/FavoritePet.php';
require_once 'rest/authentication.php';
require_once SERVER_DIR.'/AdoptionRequest.php';

define('PETS_IMAGES_DIR', SERVER_DIR.'/resources/img/pets');

use function Authentication\noHTML;

class Pet implements JsonSerializable {
    private  int    $id          ;
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
    public function __construct(){}

    public function getId          () : ?int    { return noHTML($this->id)                   ; }
    public function getName        () :  string { return noHTML($this->name)                 ; }
    public function getSpecies     () :  string { return noHTML($this->species)              ; }
    public function getAge         () :  float  { return noHTML($this->age)                  ; }
    public function getSex         () :  string { return noHTML($this->sex)                  ; }
    public function getSize        () :  string { return noHTML($this->size)                 ; }
    public function getColor       () :  string { return noHTML($this->color)                ; }
    public function getLocation    () :  string { return noHTML($this->location)             ; }
    public function getDescription () :  string { return noHTML($this->description)          ; }
    public function getStatus      () :  string { return noHTML($this->status)               ; }
    public function getAdoptionDate() : ?string { return noHTML($this->adoptionDate)         ; }
    public function getPostedBy    () : ?User   { return User::fromDatabase($this->postedBy) ; }
    public function getPostedById  () : string  { return noHTML($this->postedBy)             ; }
    /**
     * @return User|null|string
     */
    public function getAuthor      (bool $raw = false) {
        if($raw) return $this->postedBy;
        else     return $this->getPostedBy();
    }

    /**
     * Get pet pictures
     * 
     * @return array       Pet photos
     */
    public function getPictures() : array {
        $dir = PETS_IMAGES_DIR."/{$this->getId()}";
        $photos = array();
        if(!is_dir($dir)) return $photos;
        
        $lst = scandir($dir);
        foreach($lst as $fileName){
            $filePath = "$dir/$fileName";
            if(in_array(pathinfo($filePath)['extension'], IMAGES_EXTENSIONS)){
                $url = path2url($filePath);
                array_push($photos, $url);
            }
        }

        return $photos;
    }

    /**
     * Get pet main picture
     *
     * @return ?string       URL of pet main photo
     */
    public function getMainPicture() : ?string {
        $pictures = $this->getPictures();
        return (count($pictures) < 1 ?
            null :
            $pictures[0]
        );
    }

    /**
     * Get comments about a pet.
     *
     * @param integer $id   ID of the pet
     * @return array        Array of comments about that pet
     */
    public function getComments() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Comment WHERE pet=:id');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Comment');
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        $comments = $stmt->fetchAll();
        return $comments;
    }

    public function setId (int $id) : void { 
        $newId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $this->id = $newId; 
    }

    public function setName (string $name) : void { 
        $newName = filter_var($name, FILTER_SANITIZE_STRING);
        $this->name = $newName; 
    }

    public function setSpecies (string $species) : void { 
        $newSpecies = filter_var($species, FILTER_SANITIZE_STRING);
        $this->species = $newSpecies; 
    }

    public function setAge (float $age) : void { 
        $newAge = filter_var($age, FILTER_SANITIZE_NUMBER_INT);
        $this->age = $newAge; 
    }

    public function setSex (string $sex) : void { 
        $newSex = filter_var($sex, FILTER_SANITIZE_STRING);
        $this->sex = $newSex; 
    }

    public function setSize (string $size) : void { 
        $newSize = filter_var($size, FILTER_SANITIZE_NUMBER_INT);
        $this->size = $newSize; 
    }

    public function setColor (string $color) : void { 
        $newColor = filter_var($color, FILTER_SANITIZE_STRING);
        $this->color = $newColor; 
    }

    public function setLocation (string $location) : void { 
        $newLocation = filter_var($location, FILTER_SANITIZE_STRING);
        $this->location = $newLocation; 
    }

    public function setDescription (string $description) : void { 
        $newDescription = filter_var($description, FILTER_SANITIZE_STRING);
        $this->description = $newDescription; 
    }

    public function setStatus (string $status) : void { 
        $newStatus = filter_var($status, FILTER_SANITIZE_STRING);
        $this->status = $newStatus; 
    }

    public function setPostedBy (string $postedBy) : void { 
        $newpostedBy = filter_var($postedBy, FILTER_SANITIZE_STRING);
        $this->postedBy = $newpostedBy; 
    }
    
    public function setAdoptionDate(?string $adoptionDate) : void { $this->adoptionDate = $adoptionDate; }
    public function setAuthor      ( string $author      ) : void { $this->setPostedBy($author)        ; }

    public function jsonSerialize() {
		return get_object_vars($this);
    }
    
    public function addToDatabase(): void{
        global $db;
        $stmt = $db->prepare('INSERT INTO Pet
        (name, species, age, sex, size, color, location, description, postedBy)
        VALUES
        (:name, :species, :age, :sex, :size, :color, :location, :description, :postedBy)');
        $stmt->bindValue(':name'       , $this->name       );
        $stmt->bindValue(':species'    , $this->species    );
        $stmt->bindValue(':age'        , $this->age        );
        $stmt->bindValue(':sex'        , $this->sex        );
        $stmt->bindValue(':size'       , $this->size       );
        $stmt->bindValue(':color'      , $this->color      );
        $stmt->bindValue(':location'   , $this->location   );
        $stmt->bindValue(':description', $this->description);
        $stmt->bindValue(':postedBy'   , $this->postedBy   );
        $stmt->execute();
        $this->id = $db->lastInsertId();
        
        $newPet = Pet::fromDatabase($this->id);
        $this->setStatus      ($newPet->getStatus      ());
        $this->setAdoptionDate($newPet->getAdoptionDate());
    }

    static public function fromDatabase(int $id) : Pet {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet WHERE id=:id');
        $stmt->bindValue(':id', $id);
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
        $stmt->bindValue(':id'         , $this->id         );
        $stmt->bindValue(':name'       , $this->name       );
        $stmt->bindValue(':species'    , $this->species    );
        $stmt->bindValue(':age'        , $this->age        );
        $stmt->bindValue(':sex'        , $this->sex        );
        $stmt->bindValue(':size'       , $this->size       );
        $stmt->bindValue(':color'      , $this->color      );
        $stmt->bindValue(':location'   , $this->location   );
        $stmt->bindValue(':description', $this->description);
        return $stmt->execute();
    }

    public function delete() : void {
        rmdir_recursive(PETS_IMAGES_DIR."/{$this->getId()}");

        global $db;
        $stmt = $db->prepare('DELETE FROM Pet
        WHERE id=:id');
        $stmt->bindValue(':id', $this->getId());
        $stmt->execute();
    }

    static public function deletefromDatabase(int $id) : void {
        Pet::fromDatabase($id)->delete();
    }


    /**
     * Get array of all pets listed for adoption.
     *
     * @return array    Array of all pets listed for adoption
     */
    static public function getForAdoption() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet WHERE status="forAdoption"');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }

    /**
     * Get array of all pets adopted.
     *
     * @return array    Array of all pets adopted
     */
    static public function getAdopted() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Pet WHERE status="adopted"');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Pet');
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }

    public function getAdoptionRequests() : array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM AdoptionRequest WHERE pet=:id');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'AdoptionRequest');
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        $pets = $stmt->fetchAll();
        return $pets;
    }

    /**
     * Add pet to user's favorites list.
     *
     * @param User $username User's username
     */
    public function addToFavorites(User $user) : void {
        global $db;
        $favoritePets = $user->getFavoritePets();
        foreach ($favoritePets as $pet)
            if ($pet->getId() == $this->getId())
                return;
        $stmt = $db->prepare('INSERT INTO FavoritePet(username, petId)
        VALUES (:username, :id)');
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->bindValue(':id'      , $this->getId()      );
        $stmt->execute();
    }

    /**
     * Remove pet from user's favorites list.
     *
     * @param string $username  User's username
     * @param integer $id       ID of pet
     * @return void
     */
    public function removeFromFavorites(User $user) : void {
        global $db;
        $stmt = $db->prepare('DELETE FROM FavoritePet WHERE
        username=:username AND petId=:id');
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->bindValue(':id'      , $this->getId()      );
        $stmt->execute();
    }

    /**
     * Get the user who adopted the given pet.
     *
     * @param int $id           Pet's ID
     * @return ?User            User who adopted the pet
     */
    public function getAdoptedBy() : ?User {
        global $db;
        $stmt = $db->prepare('SELECT
        User.username,
        User.password,
        User.name,
        User.registeredOn,
        User.shelter
        FROM
            AdoptionRequest
            INNER JOIN Pet  ON Pet.id=AdoptionRequest.pet
            INNER JOIN User ON User.username=AdoptionRequest.user
        WHERE AdoptionRequest.outcome="accepted"
        AND Pet.status="adopted"
        AND AdoptionRequest.pet=:id');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user === false) return null;
        return $user;
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
 * @return int                  ID of the new pet
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
    array  $tmpFilePaths
) : int {
    // Check if files are OK
    foreach($tmpFilePaths as $id => $tmpFilePath)
        checkImageFile($tmpFilePath, 1000000);

    $pet = new Pet();
    $pet->setName       ($name       );
    $pet->setSpecies    ($species    );
    $pet->setAge        ($age        );
    $pet->setSex        ($sex        );
    $pet->setSize       ($size       );
    $pet->setColor      ($color      );
    $pet->setLocation   ($location   );
    $pet->setDescription($description);
    $pet->setPostedBy   ($postedBy   );
    $pet->addToDatabase();

    // Add images
    $path = PETS_IMAGES_DIR."/{$pet->getId()}";
    mkdir($path);

    foreach($tmpFilePaths as $id => $tmpFilePath){
        $ext = checkImageFile($tmpFilePath, 1000000);
        $filepath = $path.'/'.str_pad($id, 3, '0', STR_PAD_LEFT).'.jpg';
        convertImage(
            $tmpFilePath,
            $ext,
            $filepath,
            85
        );
    }

    return (int)$pet->getId();
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
        if($picture['new'] !== ''){ // new picture
            $newpic[$key] = $picture;
        } else if($picture['old'] !== ''){ //swap picture
            $swappic[$key] = $picture['old'];
        }
    }
    swapPetPictures($petId, $swappic);
    newPetPictures($petId, $newpic);

    $N = count($pictures);
    $images = scandir($path);
    foreach($images as $i => $tmpFilePathname){
        if($tmpFilePathname == '.' || $tmpFilePathname == '..') continue;
        $id = intval(explode('.', $tmpFilePathname)[0]);
        $tmpFilePathpath = "$path/$tmpFilePathname";
        if($id >= $N) unlink($tmpFilePathpath);
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

    foreach($newpic as $id => $tmpFilePath){
        $ext = checkEditImageFile($tmpFilePath, PET_PICTURE_MAX_SIZE);
        $tmpFilePathpath = $path.'/'.str_pad($id, 3, '0', STR_PAD_LEFT).'.jpg';
        convertImage(
            $tmpFilePath['new'],
            $ext,
            $tmpFilePathpath,
            85
        );
    }
}

define('IMAGES_EXTENSIONS', ['jpg']);

/**
 * Get pet main picture
 *
 * @param Pet $pet      Pet
 * @return string       URL of pet main photo
 */
function getPetMainPhoto(Pet $pet) : string {
    $picture = $pet->getMainPicture();
    return ($picture == null ? PROTOCOL_CLIENT_URL.'/resources/img/no-image.svg' : $picture);
}

/**
 * Delete all the photos that are in the comments related to the pet.
 *
 * @param integer $id    ID of pet
 * @return void
 */
function deleteAllPetCommentPhotos(int $id){
    $comments = Pet::fromDatabase($id)->getComments();
    foreach($comments as $comment)
        if (getCommentPicture($comment->getId()) !== '') // if the comment has a picture
            deletePetCommentPhoto($comment->getId());
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
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':petId', $petId);
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
    $stmt->bindValue(':petId', $petId);
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
    $stmt->bindValue(':petId', $petId);
    $stmt->execute();
    $pets = $stmt->fetchAll();
    return $pets;
}
