<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/Pet.php';

if(isset($_SESSION['username'])){
    $user = User::fromDatabase($_SESSION['username']);
    $previouslyOwnedPets = $user->getPetsAdopted();
    $title = "previously owned by" . $_SESSION['username'];
}

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/view_previously_owned_pets.php';
require_once CLIENT_DIR.'/templates/common/footer.php';