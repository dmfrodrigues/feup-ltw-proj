<?php

/**
 * Print result in specified format.
 *
 * @param mixed $result Result of request.
 */
function print_result($result) {
    switch($_SERVER['HTTP_ACCEPT']){
        case 'application/json'
    }

    header('Content-Type: application/json');
    echo(json_encode($result));
}
