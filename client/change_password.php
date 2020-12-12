<?php

session_start();

$javascript_files = ["js/signup.js"];

require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR . '/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Shelter.php';
require_once SERVER_DIR . '/errors/errors.php';

$user = User::fromDatabase($_GET['username']);

$title = "Change password";

require_once('templates/common/header.php');
if (isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username'])
    require_once('templates/users/change_password.php');

require_once('templates/common/footer.php');