<?php

session_destroy();
require_once __DIR__ . '/../server.php';
header_location('');
die();
