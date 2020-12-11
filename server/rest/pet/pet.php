<?php
require_once SERVER_DIR . '/pets.php';

$pet_id_comments_GET = function($args){
    $id = intval($args[1]);
    $ret = getPetComments($id);
    print_result($ret);
};
