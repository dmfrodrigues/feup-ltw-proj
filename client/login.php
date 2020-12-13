<?php
require_once __DIR__.'/../server/server.php';
require_once SERVER_DIR.'/connection.php';
require_once SERVER_DIR.'/notifications.php';
require_once SERVER_DIR.'/errors/errors.php';

$title = "Login";

require_once CLIENT_DIR.'/templates/common/header.php';
require_once CLIENT_DIR.'/templates/authentication/login.php';
require_once CLIENT_DIR.'/templates/common/footer.php';
