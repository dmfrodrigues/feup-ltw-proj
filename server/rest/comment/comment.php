<?php
include_once SERVER_DIR . '/pets.php';

function comment($url) {
    switch($url){
        case '': return comment_new();
        case 'photo': return comment_newphoto();
        default:
            http_response_code(400);
            die();
    }
}

function comment_new() : int {
    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $string = file_get_contents("php://input");
        $_PUT = json_decode($string, true);
        $id = addPetComment(
            $_PUT['petId'],
            $_PUT['username'],
            ($_PUT['answerTo'] === '' ? null : intval($_PUT['answerTo'])),
            $_PUT['text'],
            $_PUT['picture']
        );
        return $id;
    } else http_response_code(405); die();
}

function comment_newphoto() : string {
    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $file = fopen('php://input', 'r');
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWCOMMENTPHOTO');
        $tmpFile = fopen($tmpFilePath, 'w');
        while($data = fread($file, 1024)){
            fwrite($tmpFile, $data);
        }
        return basename($tmpFilePath);
    }
    else http_response_code(405); die();
}
