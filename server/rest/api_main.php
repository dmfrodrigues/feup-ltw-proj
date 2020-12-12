<?php

require_once __DIR__ . '/../server.php';
require_once SERVER_DIR . '/connection.php';
define('API_DIR', SERVER_DIR . '/rest');

require_once SERVER_DIR . '/connection.php';
require_once API_DIR . '/authentication.php';
require_once API_DIR . '/authorization.php';
require_once API_DIR . '/print.php';
