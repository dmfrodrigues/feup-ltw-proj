<?php

// session_start();

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Pet.php';

$pet = Pet::fromDatabase($_GET['id']);

if (isset($_SESSION['username'])){
    if($_SESSION['username'] != $pet->getPostedById()){
        header_location("/pet/{$_GET['id']}&failed=1");
        die();
    }

    deleteAllPetCommentPhotos($_GET['id']);

    Pet::deleteFromDatabase($_GET['id']);
}

header_location("/pet");

die();
