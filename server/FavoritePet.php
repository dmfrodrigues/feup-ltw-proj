<?php

class FavoritePet implements JsonSerializable {
    private string $username;
    private int    $petId   ;

    public function __construct(){}

    public function getUser  () : ?User  { return User::fromDatabase($this->username); }
    public function getUserId() : string { return $this->username                    ; }
    public function getPet   () : ?Pet   { return Pet ::fromDatabase($this->petId   ); }
    public function getPetId () : int    { return $this->petId                       ; }

    public function setUserId(string $username) : void { $this->username = $username; }
    public function setPetId (int    $petId   ) : void { $this->petId    = $petId   ; }

    public function jsonSerialize() {
		return get_object_vars($this);
    }
}
