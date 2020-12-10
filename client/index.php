<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once __DIR__.'/../server/notifications.php';

include_once('templates/common/header.php');
?> <h3><a href="pets.php">View Pets Listed For Adoption</a></h3> <?php
?> <h3><a href="adopted_pets.php">View Adopted Pets</a></h3> <?php
include_once('templates/common/footer.php');
