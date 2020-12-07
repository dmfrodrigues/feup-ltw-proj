<?php
include_once __DIR__ . '/server_constants.php';

function path2url($file, $Protocol='http://') {
    return
        $Protocol.
        str_replace(SERVER_DIR, SERVER_URL, $file);
}

class CouldNotDeleteFileException extends RuntimeException{}
