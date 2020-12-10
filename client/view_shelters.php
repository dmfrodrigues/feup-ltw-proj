<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/connection.php';
include_once __DIR__.'/../server/notifications.php';
include_once SERVER_DIR.'/shelters.php';

$shelters = getAllShelters();

include_once 'templates/common/header.php';
include_once 'templates/shelters/view_shelters.php';
include_once 'templates/common/footer.php';