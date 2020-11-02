<?php
session_start();

include_once '../server/connection.php';
include_once '../server/pets.php';
$pets = getPets();

include_once 'templates/common/header.php';
include_once 'templates/pets/list_pets.php';
include_once 'templates/common/footer.php';
