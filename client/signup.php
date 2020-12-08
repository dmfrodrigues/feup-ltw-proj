<?php 
session_start();

include_once __DIR__.'/../server/server.php';
include_once 'errors/errors.php';

$javascript_files = ['js/signup.js'];
include_once 'templates/common/header.php';
include_once 'templates/authentication/signup.php';
include_once SERVER_DIR . '/shelters.php';

include_once 'templates/common/footer.php';
