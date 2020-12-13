<?php
session_start();

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR.'/Notification.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/Shelter.php';

$title = "Edit profile";

require_once CLIENT_DIR.'/templates/common/header.php';

if ($_SESSION['username'] === $_GET['username']) {
    $user = User::fromDatabase($_GET['username']);
    require_once CLIENT_DIR.'/templates/users/edit_profile.php';
    editProfile($user);
}

require_once CLIENT_DIR.'/templates/common/footer.php';