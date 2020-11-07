<?php
session_start();

include_once __DIR__ . '/../server/server.php';
include_once SERVER_DIR . '/connection.php';
include_once SERVER_DIR . '/users.php';
removeFromFavorites($_GET['username'],$_GET['id']);

header("Location: pet.php?id=".$_GET['id']);