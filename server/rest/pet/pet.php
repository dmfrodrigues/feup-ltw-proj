<?php
require_once __DIR__ . '/../api_constants.php';
require_once SERVER_DIR . '/pets.php';

$pet_id_comments_GET = function($args): void{
    $id = intval($args[1]);
    $pet = Pet::fromDatabase($id);
    $ret = $pet->getComments($id);
    print_result($ret);
};
