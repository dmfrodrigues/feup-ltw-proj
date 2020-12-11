<?php

session_start();

$javascript_files = ["js/signup.js"];

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/connection.php';
require_once __DIR__.'/../server/notifications.php';
require_once SERVER_DIR . '/users.php';
$user = getUser($_GET['username']);

$title = "Change password";

require_once('templates/common/header.php');
if (isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username'])
    require_once('templates/users/change_password.php');

require_once('templates/common/footer.php');