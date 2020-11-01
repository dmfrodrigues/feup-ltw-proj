<?php
session_start();

include_once('../server/connection.php');
include_once('../server/users.php');
$user = getUser($_GET['username']);

include_once('templates/common/header.php');
if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['username'])
    include_once('templates/users/profile_me.php');
else
    include_once('templates/users/profile_others.php');
include_once('templates/common/footer.php');
