<?php
include_once SERVER_DIR . '/pets.php';

function comment($url) {
    switch($url){
        case '': return comment_new();
        case 'photo': return comment_newphoto();
        default:
            $parts = explode('/', $url, 2);
            $id = intval($parts[0]);
            $subpath = (count($parts) < 2 ? '' : $parts[1]);
            return comment_id($id, $subpath);
    }
}

function comment_new() : int {
    switch($_SERVER['REQUEST_METHOD']){
        case 'PUT':
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
        default: http_response_code(405); die();
    }
}

function comment_newphoto() : string {
    switch($_SERVER['REQUEST_METHOD']){
        case 'PUT':
            $file = fopen('php://input', 'r');
            $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWCOMMENTPHOTO');
            $tmpFile = fopen($tmpFilePath, 'w');
            while($data = fread($file, 1024)){
                fwrite($tmpFile, $data);
            }
            return basename($tmpFilePath);
        default: http_response_code(405); die();
    }
}

function comment_id(int $id, string $subpath) {
    switch($subpath){
        case 'photo': return comment_id_photo($id);
        default:
            switch($_SERVER['REQUEST_METHOD']){
                case 'GET': return getPetComment($id);
                case 'PUT':
                    $string = file_get_contents("php://input");
                    $_PUT = json_decode($string, true);
                    return editPetComment(
                        $id,
                        $_PUT['text'],
                        false,
                        null
                    );
                default: http_response_code(405); die();
            }
    }
}

function comment_id_photo(int $id) {
    switch($_SERVER['REQUEST_METHOD']){
        case 'PUT':
            // TODO: Replace this part by a PUT request to comment/photo
            $file = fopen('php://input', 'r');
            $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWCOMMENTPHOTO');
            $tmpFile = fopen($tmpFilePath, 'w');
            while($data = fread($file, 1024)){
                fwrite($tmpFile, $data);
            }

            setCommentPhoto($id, $tmpFilePath);
            
            return "comment/{$id}/photo";
        case 'DELETE':
            try{
                deletePetCommentPhoto($id);
                return "comment/{$id}/photo";
            } catch(CouldNotDeleteFileException $e){
                http_response_code(404); die();
            }
            break;
        default: http_response_code(405); die();
    }
}
