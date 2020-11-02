<?php
session_start();

include_once '../server/connection.php';
include_once '../server/pets.php';
$pet = getPet($_GET['id']);

include_once 'templates/common/header.php';
include_once 'templates/pets/edit_pet.php';
include_once 'templates/common/footer.php';
