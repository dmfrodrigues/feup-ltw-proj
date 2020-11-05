<?php
include_once('../server/connection.php');
include_once('../server/users.php');
addToFavorites($_GET['username'],$_GET['id']);

header("Location: pet.php?id=".$_GET['id']);

