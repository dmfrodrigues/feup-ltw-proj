<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once SERVER_DIR.'/users.php';
$user = getUser($_GET['username']);

include_once 'templates/common/header.php';
if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username'])
    include_once 'templates/users/profile_me.php';
else
    include_once 'templates/users/profile_others.php';
include_once 'templates/common/footer.php';
