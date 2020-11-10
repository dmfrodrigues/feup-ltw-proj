<?php
session_start();

include_once __DIR__.'/../server/server.php';

$javascript_files = ['js/addPet.js'];

include_once 'templates/common/header.php';
include_once 'templates/pets/add_pet.php';
include_once 'templates/common/footer.php';
