<?php

use function Authentication\noHTML;

class FavoritePet implements JsonSerializable {
    private string $username;
    private int    $petId   ;

    public function __construct(){}

    public function getUser  () : ?User  { return User::fromDatabase($this->username) ; }
    public function getUserId() : string { return noHTML($this->username);            ; }
    public function getPet   () : ?Pet   { return Pet ::fromDatabase($this->petId)    ; }
    public function getPetId () : int    { return noHTML($this->petId)                ; }

    public function setUserId(string $username) : void { 
      $newUsername = filter_var($username, FILTER_SANITIZE_STRING);
      $this->username = $newUsername; 
    }
    public function setPetId (int $petId) : void {
      $newpetId = filter_var($petId, FILTER_SANITIZE_NUMBER_INT);
      $this->petId = $newpetId; 
    }

    public function jsonSerialize() {
		return get_object_vars($this);
    }
}
