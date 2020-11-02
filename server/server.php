<?php
define('SERVER_DIR', __DIR__);
define('SERVER_URL', '../server');

function serverpathToUrl($path) : string {
    $pos = strpos($path, SERVER_DIR);
    if($pos === false) throw new RuntimeException("Invalid server path '$path' cannot be converted");
    $url = str_replace(SERVER_DIR, SERVER_URL, $path);
    return $url;
}
