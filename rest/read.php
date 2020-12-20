<?php

function getPUT() : array {
    $string = file_get_contents("php://input");
    $_PUT = json_decode($string, true);
    return $_PUT;
}
