<?php
session_start();
session_destroy();
require_once __DIR__ . '/../server.php';
header('Location: ' . PROTOCOL_API_URL);
die();