<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/shelters.php';
include_once 'errors/errors.php';

$users = getUserShelterInvitation($_SESSION['username']);

include_once 'templates/common/header.php';

if(isset($_SESSION['username']))
    include_once 'templates/users/view_potential_collaborators.php';

include_once 'templates/common/footer.php';