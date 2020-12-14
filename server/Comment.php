<?php

require_once __DIR__.'/server.php';
require_once __DIR__.'/Pet.php';

use function Authentication\noHTML;

define('COMMENTS_IMAGES_DIR', SERVER_DIR . '/resources/img/comments');

class Comment implements JsonSerializable {
    private int    $id      ;
    private string $postedOn;
    private string $text    ;
    private int    $pet     ;
    private string $user    ;
    private ?int   $answerTo;

    public function __construct(){}

    public function getId      () : int    { return noHTML($this->id)                      ; }
    public function getPostedOn() : string { return noHTML($this->postedOn)                ; }
    public function getText    () : string { return noHTML($this->text)                    ; }
    public function getPet     () : Pet    { return Pet::fromDatabase($this->pet)          ; }
    public function getPetId   () : int    { return noHTML($this->pet)                     ; }
    public function getUser    () : ?User  { return User::fromDatabase($this->user)        ; }
    public function getAuthor  () : ?User  { return $this->getUser()                       ; }
    public function getUserId  () : string { return noHTML($this->user)                    ; }
    public function getAuthorId() : string { return noHTML($this->getUserId())             ; }
    public function getAnswerTo() : ?int   { return noHTML($this->answerTo)                ; }
    public function getPictureUrl() : string {
        return SERVER_DIR . "resources/img/comments/{$this->getId()}.jpg";
    }
    
    public function setId (int $id) : void { 
        $newId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $this->id = $newId; 
    }

    public function setText (string $text) : void {
        $newText = filter_var($text, FILTER_SANITIZE_STRING);
        $this->text = $newText; 
    }

    public function setPetId (int $pet) : void {
        $newPetId = filter_var($pet, FILTER_SANITIZE_NUMBER_INT);
        $this->pet  = $newPetId; 
    }

    public function setUserId (string $user) : void {
        $newUser = filter_var($user, FILTER_SANITIZE_STRING);
        $this->user = $newUser; 
    }

    public function setAuthorId(string $author) : void {
        $newAuthor = filter_var($author, FILTER_SANITIZE_STRING);
        $this->setUserId($newAuthor)  ; 
    }

    public function setAnswerTo(?int $answerTo) : void {
        $newanswerTo= filter_var($answerTo, FILTER_SANITIZE_NUMBER_INT);
        $this->answerTo = $newanswerTo; 
    }
    
    public function setPostedOn (string $postedOn) : void {$this->postedOn = $postedOn; }

    public function jsonSerialize() {
		return get_object_vars($this);
    }

    /**
     * Get comment about a pet.
     *
     * @param integer $commentId    ID of comment
     * @return Comment              Comment
     */
    static public function fromDatabase(int $id) : ?Comment {
        global $db;
        $stmt = $db->prepare('SELECT * FROM Comment WHERE id=:id');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Comment');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $comment = $stmt->fetch();
        return $comment;
    }

    public function delete() : void {
        global $db;
        $stmt = $db->prepare('DELETE FROM Comment WHERE id=:id');
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
    }
}

function getPetComment(int $commentId) : ?Comment {
    return Comment::fromDatabase($commentId);
}

/**
 * Adds comment about pet.
 *
 * @param integer $id       ID of pet
 * @param string $username  User's username
 * @param ?int $answerTo    ID of comment it is replying to, or null if not a reply
 * @param string $text      Text of the comment
 * @param array $tmpFilePath       Is tmpFilePath coming or not?
 * @return integer          ID of the new comment
 */
function addPetComment(int $id, string $username, ?int $answerTo, string $text, ?string $tmpFileId) : int {
    if($tmpFileId == null && $text == '')
        throw new RuntimeException('Comment must have a text or an image');

    if($tmpFileId != null){
        $tmpFilePath = sys_get_temp_dir().'/'.$tmpFileId;
        checkImageFile($tmpFilePath, COMMENT_PICTURE_MAX_SIZE);
    }

    global $db;
    
    $stmt = $db->prepare('INSERT INTO Comment
    (pet, user, answerTo, text)
    VALUES
    (:pet, :user, :answerTo, :text)');
    $stmt->bindValue(':pet'        , $id         );
    $stmt->bindValue(':user'       , $username   );
    $stmt->bindValue(':answerTo'   , $answerTo   );
    $stmt->bindValue(':text'       , $text       );
    $stmt->execute();
    $commentId = (int)$db->lastInsertId();

    if($tmpFileId != null){
        setCommentPhoto($commentId, $tmpFilePath);
    }

    return $commentId;
}

function setCommentPhoto(int $commentId, string $tmpFilePath) : void {
    $ext = checkImageFile($tmpFilePath, COMMENT_PICTURE_MAX_SIZE);
    $tmpFilePathpath = COMMENTS_IMAGES_DIR . "/$commentId.jpg";
    convertImage(
        $tmpFilePath,
        $ext,
        $tmpFilePathpath,
        85
    );
}

/**
 * Edits comment about pet.
 *
 * @param integer   $commentId      ID of comment
 * @param string    $text           Text of comment
 * @param string    $tmpFilePath    Picture tmpFilePath (as obtained from $_FILES['tmpFilePath_field'])
 * @return void
 */
function editPetComment(int $commentId, string $text, bool $deleteFile, ?string $tmpFilePath){
    $oldComment = Comment::fromDatabase($commentId);

    $noFileSent = false;
    try{
        $ext = checkImageFile($tmpFilePath, 1000000);
    } catch(NoFileSentException $e){
        $noFileSent = true;
    }
    if($text === '' && $noFileSent && ($deleteFile || $oldComment == null || $oldComment->getPictureUrl() === ''))
        throw new RuntimeException('Comment must have a text or an image');

    global $db;
    
    $stmt = $db->prepare('UPDATE Comment SET
    text=:text
    WHERE id=:id');
    $stmt->bindValue(':text', $text     );
    $stmt->bindValue(':id'  , $commentId);
    $stmt->execute();
    
    if($deleteFile){
        deletePetCommentPhoto($commentId);
    }

    if(!$noFileSent){
        $filePath = COMMENTS_IMAGES_DIR . "/$commentId.jpg";
        convertImage(
            $tmpFilePath,
            $ext,
            $filePath,
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
    $stmt->bindValue(':id', $id);
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
    $path = SERVER_DIR . "/resources/img/comments/$id.jpg";
    if(!file_exists($path)) return null;
    return path2url($path);
}

/**
 * Delete comment photo.
 *
 * @param integer $commentId    ID of comment
 * @return void
 */
function deletePetCommentPhoto(int $commentId){
    $tmpFilePathpath = COMMENTS_IMAGES_DIR . "/$commentId.jpg";
    if(file_exists($tmpFilePathpath))
        if(!unlink($tmpFilePathpath))
            throw new CouldNotDeleteFileException("Could not delete '$tmpFilePathpath'");
}
