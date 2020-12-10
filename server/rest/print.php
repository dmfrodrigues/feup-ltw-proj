<?php

/**
 * Print result in specified format.
 *
 * @param mixed $result Result of request.
 * @return void
 */
function print_result($result): void {
    switch($_SERVER['HTTP_ACCEPT']){
        case 'application/json':
            header('Content-Type: application/json');
            echo(json_encode($result));
            break;
        default: http_response_code(415); die();
    }
}
