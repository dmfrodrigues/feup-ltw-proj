<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR . '/users.php';
include_once SERVER_DIR . '/shelters.php';

$shelterInvitations = getUserShelterInvitation($_SESSION['username']);

include_once 'templates/common/header.php';
include_once 'templates/pets/view_shelter_invitations.php';
drawShelterInvitations($shelterInvitations);
include_once 'templates/common/footer.php';
