<?php
/**
 * Receives the following arguments:
 * - _GET:
 *     - id     ID of pet
 * - _POST:
 *     - idx    Index of image
 * - _FILES     File to upload, with name 'pet_picture'
 */

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'server/pets.php';

$pet = getPet($_GET['id']);

if($pet['postedBy'] != $_SESSION['username']){
    header("Location: pet.php?id={$pet['id']}");
}

$file = $_FILES['profile_picture'];
$idx  = $_POST['idx'];

try{
    addPetPhoto($pet['id'], $_FILES['pet_picture']['tmp_name'], $idx);

    header("Location: edit_pet.php?id={$pet['id']}");
} catch (RuntimeException $e) {
    echo $e->getMessage();
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', true, 400);
}
