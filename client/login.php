<?php
session_start();

include_once __DIR__.'/../server/server.php';
include_once SERVER_DIR.'/errors/errors.php';
include_once 'templates/common/header.php';
include_once 'templates/authentication/login.php';
include_once 'templates/common/footer.php';
