<?php

require_once __DIR__.'/server.php';
require_once __DIR__.'/Pet.php';

define('COMMENTS_IMAGES_DIR', SERVER_DIR . '/resources/img/comments');


class Comment implements JsonSerializable {
    private int    $id      ;
    private string $postedOn;
    private string $text    ;
    private int    $pet     ;
    private string $user    ;
    private ?int   $answerTo;

    public function __construct(){}

    public function getId      () : int    { return $this->id                      ; }
    public function getPostedOn() : string { return $this->postedOn                ; }
    public function getText    () : string { return $this->text                    ; }
    public function getPet     () : Pet    { return Pet::fromDatabase($this->pet)  ; }
    public function getPetId   () : int    { return $this->pet                     ; }
    public function getUser    () : ?User  { return User::fromDatabase($this->user); }
    public function getAuthor  () : ?User  { return $this->getUser()               ; }
    public function getUserId  () : string { return $this->user                    ; }
    public function getAuthorId() : string { return $this->getUserId()             ; }
    public function getAnswerTo() : ?int   { return $this->answerTo                ; }
    public function getPictureUrl() : string {
        return SERVER_DIR . "resources/img/comments/{$this->getId()}.jpg";
    }
    
    public function setId      (int    $id      ) : void { $this->id       = $id      ; }
    public function setPostedOn(string $postedOn) : void { $this->postedOn = $postedOn; }
    public function setText    (string $text    ) : void { $this->text     = $text    ; }
    public function setPetId   (int    $pet     ) : void { $this->pet      = $pet     ; }
    public function setUserId  (string $user    ) : void { $this->user     = $user    ; }
    public function setAuthorId(string $author  ) : void { $this->setUserId($author)  ; }
    public function setAnswerTo(?int   $answerTo) : void { $this->answerTo = $answerTo; }
    
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
