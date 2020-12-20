<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR.'/classes/User.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Pet.php';
require_once SERVER_DIR.'/classes/Shelter.php';
require_once SERVER_DIR.'/classes/Notification.php';

$title = $user->getUsername();

require_once CLIENT_DIR.'/templates/common/header.php';
if(isShelter($user->getUsername())) {
    $shelter = Shelter::fromDatabase($user->getUsername());
    $added_pets = $shelter->getPetsForAdoption();
    $collaborators = $shelter->getCollaborators();

    if(isset($_SESSION['username']) && isset($_SESSION['isShelter']) && $_SESSION['username'] == $user->getUsername())
        require_once CLIENT_DIR.'/templates/shelters/profile_shelter_me.php';
    else
        require_once CLIENT_DIR.'/templates/shelters/profile_shelter_others.php';
} else {
    $user = User::fromDatabase($user->getUsername());
    if($user == null){ my_response_code(404); die(); }
    $added_pets = $user->getPetsNotAdopted();
    $favorite_pets = $user->getFavoritePets();

    if(isset($_SESSION['username']) && $_SESSION['username'] == $user->getUsername()) {
        require_once CLIENT_DIR.'/templates/users/profile_me.php';
    } else
        require_once CLIENT_DIR.'/templates/users/profile_others.php';
}
require_once CLIENT_DIR.'/templates/common/footer.php';