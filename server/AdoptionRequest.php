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

/**
 * Get a specific adoption request given it's id.
 * 
 * @param int $id   Adoption Request id
 * @return array    The adoption request with the pet's owner.
 */
function getAdoptionRequest(int $id): array {
  global $db;
  
  $stmt = $db->prepare('SELECT 
      AdoptionRequest.id,
      AdoptionRequest.text,
      AdoptionRequest.outcome,
      AdoptionRequest.pet,
      AdoptionRequest.user,
      AdoptionRequest.requestDate AS messDate,
      Pet.postedBy,
      Pet.name AS petName
      FROM AdoptionRequest INNER JOIN Pet ON Pet.id=AdoptionRequest.pet
      WHERE AdoptionRequest.id=:id');
  $stmt->bindValue(':id', $id);
  $stmt->execute();
  $adoptionRequest = $stmt->fetch();
  return $adoptionRequest;
}

function getAdoptionRequestMessages(int $reqId) : array {
  global $db;

  $stmt = $db->prepare('SELECT 
      AdoptionRequestMessage.text, 
      AdoptionRequestMessage.request,
      AdoptionRequestMessage.id,
      AdoptionRequestMessage.messageDate AS messDate,
      AdoptionRequestMessage.user,
      AdoptionRequest.outcome,
      AdoptionRequest.pet,
      Pet.name AS petName
      FROM AdoptionRequestMessage 
      INNER JOIN AdoptionRequest ON AdoptionRequest.id=AdoptionRequestMessage.request
      INNER JOIN Pet ON AdoptionRequest.pet=Pet.id
      WHERE AdoptionRequestMessage.request=:reqId');
  $stmt->bindValue(':reqId', $reqId);
  $stmt->execute();
  $adoptionRequestMessages = $stmt->fetchAll();
  return $adoptionRequestMessages;
} 

/**
* Change adoption request outcome
*
* @param int $reqId
* @param string $outcome  Adoption Request outcome
*
* @return bool            True if successful, false otherwise.
*/
function changeAdoptionRequestOutcome(int $reqId, string $outcome) : bool {
  global $db;
  
  $stmt = $db->prepare('UPDATE
  AdoptionRequest SET outcome=:outcome WHERE id=:reqId'); 
  $stmt->bindValue(':outcome', $outcome);
  $stmt->bindValue(':reqId', $reqId);
  $stmt->execute();
  return $stmt->rowCount() > 0;
}

/**
 * Have the user requested the pet?
 *
 * @param string $username  User's username
 * @param int $petId        Pet's ID
 * @return bool             Have the user requested the pet?
 */
function userRequestedPet(string $username, int $petId) : bool {
  $user = User::fromDatabase($username);
  $adoption_requests = $user->getAdoptionRequestsToOthers();
  foreach ($adoption_requests as $request) {
      if ($request->getPetId() == $petId) return true;
  }
  return false;
}

/**
 * Get the adoption request outcome.
 *
 * @param string $username    User's username
 * @param string $petId       Pet's ID
 * @return ?string            Outcome of the adoption request made by the user to the pet, or null if there is none
 */
function getAdoptionRequestOutcome(string $username, string $petId) : ?string {
  global $db;
  $stmt = $db->prepare('SELECT outcome FROM AdoptionRequest
  WHERE user=:username AND pet=:petId ORDER BY requestDate DESC');
  $stmt->bindValue(':username', $username);
  $stmt->bindValue(':petId', $petId);
  $stmt->execute();
  $request = $stmt->fetchAll();
  return $request[0]['outcome'];
}

/**
* Add adoption request
*
* @param string $username  Username of user that created request
* @param integer $id       ID of pet the adoption request refers to
* @param string $text      Text of the adoption request
*
* @return string ID of the adoption request
*/
function addAdoptionRequest(string $username, int $id, string $text) : string {
  global $db;
  $stmt = $db->prepare('INSERT INTO AdoptionRequest
  (user, pet, text)
  VALUES
  (:user, :pet, :text)');
  $stmt->bindValue(':user'       , $username   );
  $stmt->bindValue(':pet'        , $id         );
  $stmt->bindValue(':text'       , $text       );
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
  $stmt->bindValue(':username', $username);
  $stmt->bindValue(':petId', $petId);
  $stmt->execute();
  return $stmt->rowCount() > 0;
}

/**
* Refuses other proposals made to the pet, because the pet was adopted.
* 
* @param integer $requestId    Request Id
* @param integer $petId        Pet's Id
* @return array                Array of users with rejected proposals
*/
function refuseOtherProposals(int $requestId, int $petId) {
  $refusedUsers = array();
  $adoption_requests = Pet::fromDatabase($petId)->getAdoptionRequests();
  foreach ($adoption_requests as $request){
      if ($request->getId() != $requestId) {
          $request->setOutcome("rejected");
          array_push($refusedUsers, $request->getUser());
      }
  } 
  return $refusedUsers;
}
