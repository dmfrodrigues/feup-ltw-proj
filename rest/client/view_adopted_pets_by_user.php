<?php

require_once __DIR__.'/../../server.php';
require_once SERVER_DIR . '/rest/authentication.php';
Authentication\CSPHeaderSet();
$CSRFtoken = Authentication\CSRF_GetToken();
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/classes/Notification.php';
require_once SERVER_DIR . '/classes/User.php';
require_once SERVER_DIR . '/classes/Shelter.php';
require_once SERVER_DIR . '/classes/Pet.php';

if(isset($_SESSION['username'])){
    $user = User::fromDatabase($_SESSION['username']);
    $adoptedPets = $user->getPetsIAdopted();
    $title = "Adopted pets by " . $_SESSION['username'];
}

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/pets/view_adopted_pets_by_user.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
