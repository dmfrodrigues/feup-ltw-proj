<?php
namespace Authorization {
    require_once __DIR__.'/../server.php';
    require_once SERVER_DIR.'/User.php';
    require_once SERVER_DIR.'/Pet.php';
    require_once SERVER_DIR.'/Shelter.php';

    abstract class Method {
        const READ  = 0;
        const WRITE = 1;
        const EDIT  = 2;
    }
    abstract class Resource {
        const PROFILE                  = 1;
        const NOTIFICATION             = 2;
        const PET                      = 3;
        const ADOPTION_REQUEST         = 4;
        const ADOPTION_REQUEST_MESSAGE = 5;
        const COMMENT                  = 6;
        const FAVORITE_PET             = 7;
        const SHELTER_INVITATION       = 8;
    }

    class Rules {
        static array $rules = [];
        static public function add_rule(int $resourceType, int $method, callable $rule): void{
            Rules::$rules[$resourceType][$method][] = $rule;
        }
    }
    
    // add_rule(Resource::PROFILE                 , Method::READ , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::NOTIFICATION            , Method::READ , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::PET                     , Method::READ , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::ADOPTION_REQUEST        , Method::READ , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::READ , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::COMMENT                 , Method::READ , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::FAVORITE_PET            , Method::READ , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    
    // add_rule(Resource::PROFILE                 , Method::WRITE, function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::NOTIFICATION            , Method::WRITE, function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::PET                     , Method::WRITE, function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::ADOPTION_REQUEST        , Method::WRITE, function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::WRITE, function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::COMMENT                 , Method::WRITE, function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::FAVORITE_PET            , Method::WRITE, function(\User $user, $resource) : bool { return $user->isAdmin(); });

    // add_rule(Resource::PROFILE                 , Method::EDIT , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::NOTIFICATION            , Method::EDIT , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::PET                     , Method::EDIT , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::ADOPTION_REQUEST        , Method::EDIT , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::EDIT , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::COMMENT                 , Method::EDIT , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    // add_rule(Resource::FAVORITE_PET            , Method::EDIT , function(\User $user, $resource) : bool { return $user->isAdmin(); });
    
    // ======================================================== PROFILE ========================================================
    Rules::add_rule(Resource::PROFILE, Method::READ , function(?\User $user, ?\User $otherUser) : bool { return true               ; }); // Everyone can see
    Rules::add_rule(Resource::PROFILE, Method::WRITE, function(?\User $user, ?\User $otherUser) : bool { return true               ; }); // Everyone can write
    Rules::add_rule(Resource::PROFILE, Method::EDIT , function(?\User $user, ?\User $otherUser) : bool { return $user == $otherUser; }); // Edit itself
    
    // ======================================================== PET ========================================================

    Rules::add_rule(Resource::PET, Method::READ , function(?\User $user, ?\Pet $pet) : bool { return true                      ; }); // Everyone can see
    Rules::add_rule(Resource::PET, Method::WRITE, function(?\User $user, ?\Pet $pet) : bool { return $user !== null            ; }); // Anyone can write
    Rules::add_rule(Resource::PET, Method::EDIT , function(?\User $user, ?\Pet $pet) : bool {                                        // if pet was adopted, only the user who adopted it can edit it
        if ($user == null) return false;
        if ($pet->getStatus() === "forAdoption") return false;
        return ($user == $pet->getAdoptedBy());
    });
    Rules::add_rule(Resource::PET, Method::EDIT , function(?\User $user, ?\Pet $pet) : bool {                                        // associated shelter can edit it
        if ($user    == null) return false;
        if ($pet->getStatus() !== "forAdoption") return false;
        $shelter = $pet->getAuthor()->getShelter();
        if ($shelter == null) return false;
        return $shelter->getUsername() == $user->getUsername();
    });
    Rules::add_rule(Resource::PET, Method::EDIT , function(?\User $user, ?\Pet $pet) : bool {                                        // collaborators of the associated shelter can edit it
        if ($user    == null) return false;
        if ($pet->getStatus() !== "forAdoption") return false;
        $shelter = $pet->getAuthor()->getShelter();
        if ($shelter == null) return false;
        $collaborators = $shelter->getCollaborators();
        foreach($collaborators as $collaborator) {
            if ($collaborator->getUsername() == $user->getUsername()) return true;
        }
        return false;
    });
    Rules::add_rule(Resource::PET, Method::EDIT , function(?\User $user, ?\Pet $pet) : bool {                                        // collaborators of the associated shelter can edit it
        if ($user    == null) return false;
        if ($pet->getStatus() === "forAdoption") return $user == $pet->getAuthor();
    });

    // ======================================================== ADOPTION REQUEST ========================================================
    Rules::add_rule(Resource::ADOPTION_REQUEST, Method::READ , function(?\User $user, ?\AdoptionRequest $request) : bool { return $user == $request->getAuthor()          ; }); // Author can see
    Rules::add_rule(Resource::ADOPTION_REQUEST, Method::READ , function(?\User $user, ?\AdoptionRequest $request) : bool { return $user == $request->getPet()->getAuthor(); }); // Pet owner can see
    Rules::add_rule(Resource::ADOPTION_REQUEST, Method::WRITE, function(?\User $user, ?\AdoptionRequest $request) : bool { return true                                    ; }); // Anyone can write
    Rules::add_rule(Resource::ADOPTION_REQUEST, Method::EDIT , function(?\User $user, ?\AdoptionRequest $request) : bool { return $user == $request->getAuthor()          ; }); // Author can edit
    
    // ======================================================== ADOPTION REQUEST MESSAGE ========================================================
    Rules::add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::READ , function(?\User $user, ?\AdoptionRequest $request) : bool { return $user == $request->getAuthor()          ; }); // Author can see
    Rules::add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::READ , function(?\User $user, ?\AdoptionRequest $request) : bool { return $user == $request->getPet()->getAuthor(); }); // Pet owner can see
    Rules::add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::WRITE, function(?\User $user, ?\AdoptionRequest $request) : bool { return $user == $request->getAuthor()          ; }); // Author can write
    Rules::add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::WRITE, function(?\User $user, ?\AdoptionRequest $request) : bool { return $user == $request->getPet()->getAuthor(); }); // Pet owner can write

    // ======================================================== COMMENT ========================================================
    Rules::add_rule(Resource::COMMENT, Method::READ , function(?\User $user, ?\Comment $comment) : bool { return true                          ; }); // Everyone can see
    Rules::add_rule(Resource::COMMENT, Method::WRITE, function(?\User $user, ?\Comment $comment) : bool { return $user !== null                ; }); // Everyone can write
    Rules::add_rule(Resource::COMMENT, Method::EDIT , function(?\User $user, ?\Comment $comment) : bool { return $user == $comment->getAuthor(); }); // Author can edit its own comment

    // ======================================================== FAVORITE PET ========================================================
    Rules::add_rule(Resource::FAVORITE_PET, Method::READ , function(?\User $user, ?\FavoritePet $favorite) : bool { return true                         ; }); // Everyone can see
    Rules::add_rule(Resource::FAVORITE_PET, Method::WRITE, function(?\User $user, ?\FavoritePet $favorite) : bool { return !$user->isShelter()          ; }); // All but shelters can mark a favorite

    // ======================================================== NOTIFICATION ========================================================
    Rules::add_rule(Resource::NOTIFICATION, Method::READ , function(?\User $user, ?\Notification $notification) : bool { return $notification->getUser()->getUsername() == $user->getUsername(); }); // User who received the notification
    Rules::add_rule(Resource::NOTIFICATION, Method::WRITE, function(?\User $user, ?\Notification $notification) : bool { return true; });
    
     function check(int $resourceType, int $method, ?\User $user, $resource): bool{
        if(isset(Rules::$rules[$resourceType])){
            if(isset(Rules::$rules[$resourceType][$method])){
                $current_rules = Rules::$rules[$resourceType][$method];
                foreach($current_rules as $key => $rule){
                    if($rule($user, $resource)) return true;
                }
            }
        }
        return false;
    }

    function checkAndRespond(int $resourceType, int $method, ?\User $user, $resource) : void {
        $ret = check($resourceType, $method, $user, $resource);
        if(!$ret){ http_response_code(403); die(); }
    }
}
