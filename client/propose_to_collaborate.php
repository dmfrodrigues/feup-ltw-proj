<?php

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/User.php';
require_once SERVER_DIR.'/Shelter.php';
require_once SERVER_DIR.'/Shelter.php';

$user = User::fromDatabase($_GET['username']);
$title = "Collaborate proposal";

if (isset($_SESSION['username']) && isset($_SESSION['isShelter'])) {
    $shelter = Shelter::fromDatabase($_SESSION['username']);
}

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/shelters/propose_to_collaborate.php';
require_once CLIENT_DIR.'/templates/common/footer.php';