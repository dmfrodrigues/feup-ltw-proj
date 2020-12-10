<?php

namespace Authorization {
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
    }

    $rules = [];
    function add_rule(int $resourceType, int $method, callable $rule){ $rules[$resourceType][$method] = $rule; }

    // ADMIN IS GOD
    add_rule(Resource::PROFILE                 , Method::READ , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::NOTIFICATION            , Method::READ , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::PET                     , Method::READ , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::ADOPTION_REQUEST        , Method::READ , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::READ , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::COMMENT                 , Method::READ , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::FAVORITE_PET            , Method::READ , function(User $user, $resource){ return $user->isAdmin(); });
    
    add_rule(Resource::PROFILE                 , Method::WRITE, function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::NOTIFICATION            , Method::WRITE, function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::PET                     , Method::WRITE, function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::ADOPTION_REQUEST        , Method::WRITE, function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::WRITE, function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::COMMENT                 , Method::WRITE, function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::FAVORITE_PET            , Method::WRITE, function(User $user, $resource){ return $user->isAdmin(); });

    add_rule(Resource::PROFILE                 , Method::EDIT , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::NOTIFICATION            , Method::EDIT , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::PET                     , Method::EDIT , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::ADOPTION_REQUEST        , Method::EDIT , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::EDIT , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::COMMENT                 , Method::EDIT , function(User $user, $resource){ return $user->isAdmin(); });
    add_rule(Resource::FAVORITE_PET            , Method::EDIT , function(User $user, $resource){ return $user->isAdmin(); });
    
    // ======================================================== PROFILE ========================================================
    add_rule(Resource::PROFILE, Method::READ , function(User $user, User $otherUser){ return true               ; }); // Everyone can see
    add_rule(Resource::PROFILE, Method::EDIT , function(User $user, User $otherUser){ return $user == $otherUser; }); // Edit itself
    
    // ======================================================== PET ========================================================
    add_rule(Resource::PET, Method::READ , function(User $user, Pet $pet){ return true                                    ; }); // Everyone can see
    add_rule(Resource::PET, Method::WRITE, function(User $user, Pet $pet){ return $pet->getAuthor() == $user              ; }); // Author can write
    add_rule(Resource::PET, Method::EDIT , function(User $user, Pet $pet){ return $pet->getAuthor()->getShelter() == $user; }); // Author can edit
    
    // ======================================================== ADOPTION REQUEST ========================================================
    add_rule(Resource::ADOPTION_REQUEST, Method::READ , function(User $user, AdoptionRequest $request){ return $user == $request->getAuthor()          ; }); // Author can see
    add_rule(Resource::ADOPTION_REQUEST, Method::READ , function(User $user, AdoptionRequest $request){ return $user == $request->getPet()->getAuthor(); }); // Pet owner can see
    add_rule(Resource::ADOPTION_REQUEST, Method::WRITE, function(User $user, AdoptionRequest $request){ return $user == $request->getAuthor()          ; }); // Author can write
    
    // ======================================================== ADOPTION REQUEST MESSAGE ========================================================
    add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::READ , function(User $user, AdoptionRequestMessage $message){ return $user == $message->getRequest()->getAuthor()          ; }); // Author can see
    add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::READ , function(User $user, AdoptionRequestMessage $message){ return $user == $message->getRequest()->getPet()->getAuthor(); }); // Pet owner can see
    add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::WRITE, function(User $user, AdoptionRequestMessage $message){ return $user == $message->getRequest()->getAuthor()          ; }); // Author can write
    add_rule(Resource::ADOPTION_REQUEST_MESSAGE, Method::WRITE, function(User $user, AdoptionRequestMessage $message){ return $user == $message->getRequest()->getPet()->getAuthor(); }); // Pet owner can write

    // ======================================================== COMMENT ========================================================
    add_rule(Resource::COMMENT, Method::READ , function(User $user, Comment $comment){ return true                          ; }); // Everyone can see
    add_rule(Resource::COMMENT, Method::WRITE, function(User $user, Comment $comment){ return true                          ; }); // Everyone can write
    add_rule(Resource::COMMENT, Method::EDIT , function(User $user, Comment $comment){ return $user == $comment->getAuthor(); }); // Author can edit its own comment

    // ======================================================== FAVORITE PET ========================================================
    add_rule(Resource::COMMENT, Method::READ , function(User $user, FavoritePet $favorite){ return true                         ; }); // Everyone can see
    add_rule(Resource::COMMENT, Method::WRITE, function(User $user, FavoritePet $favorite){ return $user == $favorite->getUser(); }); // User can write

    function check(int $resourceType, int $method, User $user, $resource){
        if(isset($rules[$resourceType])){
            if(isset($rules[$resourceType][$method])){
                $current_rules = $rules[$resourceType][$method];
                foreach($current_rules as $key => $rule){
                    if($rule($user, $resource)) return true;
                }
            }
        }
        return false;
    }
}
