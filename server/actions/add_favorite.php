<?php
session_start();

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR . '/users.php';
addToFavorites($_GET['username'],$_GET['id']);

header("Location: " . CLIENT_URL . "/pet.php?id=".$_GET['id']);

