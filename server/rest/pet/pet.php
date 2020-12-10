<?php
include_once SERVER_DIR . '/pets.php';

$pet_id_comments_GET = function($args): void{
    $id = intval($args[1]);
    $ret = getPetComments($id);
    print_result($ret);
};
