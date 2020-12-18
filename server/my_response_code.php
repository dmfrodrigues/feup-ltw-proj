<?php

require_once CLIENT_DIR.'/error_page.php';

function my_response_code(int $response_code) : void {
    $code2message = [
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        409 => 'Conflict',
        412 => 'Precondition Failed',
        415 => 'Unsupported Media Type'
    ];

    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') !== false &&
       isset($code2message[$response_code])){
        $message = $code2message[$response_code];
        error_page($response_code, $message);
    }
    http_response_code($response_code);
}
