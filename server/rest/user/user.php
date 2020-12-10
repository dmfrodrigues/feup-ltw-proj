<?php
include_once SERVER_DIR . '/users.php';

$user_id_photo_GET = function($args): void{
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

$user_id_photo_PUT = function($args): void{
    $username = $args[1];
    
    $file = fopen('php://input', 'r');
    $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWPROFILEPHOTO');
    $tmpFile = fopen($tmpFilePath, 'w');
    while($data = fread($file, 1024)){
        fwrite($tmpFile, $data);
    }

    $ret = setUserPhoto($username, $tmpFilePath);
    print_result($ret);
};

$user_id_photo_DELETE = function($args): void{
    $id = $args[1];

    try{
        deleteUserPhoto($id);
        http_response_code(204);
    } catch(CouldNotDeleteFileException $e){
        http_response_code(404); die();
    }
};
