<?php
include_once SERVER_DIR . '/users.php';

$user_id_photo_GET = function($args){
    $username = $args[1];
    $ret = getUserPicture($username);
    if($ret == null){
        http_response_code(404);
        die();
    } else {
        header("Location: {$ret}");
        exit();
    }
};
