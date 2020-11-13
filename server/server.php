<?php
define('SERVER_DIR', __DIR__);          // For server
define('SERVER_URL', '../server');      // For client

define('CLIENT_URL', '../../client');   // For server

function serverpathToUrl($path) : string {
    $pos = strpos($path, SERVER_DIR);
    if($pos === false) throw new RuntimeException("Invalid server path '$path' cannot be converted");
    $url = str_replace(SERVER_DIR, SERVER_URL, $path);
    return $url;
}

class CouldNotDeleteFileException extends RuntimeException{}
