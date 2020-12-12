<?php

class AdoptionRequest implements JsonSerializable {
    private  int    $id         ;
    private  string $text       ;
    private  string $outcome    ;
    private  int    $pet        ;
    private  string $user       ;
    private  string $requestDate;

    public function __construct(){}

    public function getId      () : int    { return $this->id                      ; }
    public function getText    () : string { return $this->text                    ; }
    public function getOutcome () : string { return $this->outcome                 ; }
    public function getPet     () : Pet    { return Pet ::fromDatabase($this->pet ); }
    public function getPetId   () : int    { return $this->pet                     ; }
    public function getUser    () : ?User  { return User::fromDatabase($this->user); }
    public function getAuthor  () : ?User  { return $this->getUser()               ; }
    public function getUserId  () : string { return $this->user                    ; }
    public function getAuthorId() : string { return $this->getUserId()             ; }
    public function getDate    () : string { return $this->requestDate             ; }

    public function setId     (int    $id         ) : void { $this->id          = $id         ; }
    public function setText   (string $text       ) : void { $this->text        = $text       ; }
    public function setOutcome(string $outcome    ) : void { $this->outcome     = $outcome    ; }
    public function setPet    (int    $pet        ) : void { $this->pet         = $pet        ; }
    public function setUser   (string $user       ) : void { $this->user        = $user       ; }
    public function setAuthor (string $author     ) : void { $this->setUser($author)          ; }
    public function setDate   (string $requestDate) : void { $this->requestDate = $requestDate; }
    
    public function jsonSerialize() {
		return get_object_vars($this);
    }

    static public function fromDatabase(int $id) : AdoptionRequest {
        global $db;
        $stmt = $db->prepare('SELECT * FROM AdoptionRequest WHERE id=:id');
        $stmt->bindValue(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'AdoptionRequest');
        $stmt->execute();
        $request = $stmt->fetch();
        return $request;
    }
}

class AdoptionRequestMessage implements JsonSerializable {
    private  int    $id         ;
    private  string $text       ;
    private  int    $request    ;
    private  string $messageDate;
    private  string $user       ;
    public function __construct(){}

    public function getRequest() : AdoptionRequest { return AdoptionRequest::fromDatabase($this->request); }

    public function jsonSerialize() {
		return get_object_vars($this);
    }

    static public function fromDatabase(string $id) : AdoptionRequestMessage {
        global $db;
        $stmt = $db->prepare('SELECT * FROM AdoptionRequestMessage WHERE id=:id');
        $stmt->bindValue(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'AdoptionRequestMessage');
        $stmt->execute();
        $message = $stmt->fetch();
        return $message;
    }
}
