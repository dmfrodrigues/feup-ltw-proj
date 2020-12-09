<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

include_once __DIR__ . '/../server.php';
include_once SERVER_DIR . '/connection.php';
define('API_DIR', SERVER_DIR . '/rest');
include_once API_DIR . '/pet/pet.php';
include_once API_DIR . '/comment/comment.php';

$url = $_GET['url'];

$parts = explode('/', $url, 2);
$path = $parts[0];
if(count($parts) < 2) $subpath = ''; else $subpath = $parts[1];

switch($path){
    case 'pet'    : $ret = pet    ($subpath); break;
    case 'comment': $ret = comment($subpath); break;
    default: http_response_code(400); die();
}

header('Content-Type: application/json');
echo(json_encode($ret));
