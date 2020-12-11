<?php
require_once SERVER_DIR . '/pets.php';

$comment_PUT = function($args){
            $string = file_get_contents("php://input");
            $_PUT = json_decode($string, true);
            $id = addPetComment(
                $_PUT['petId'],
                $_PUT['username'],
                ($_PUT['answerTo'] === '' ? null : intval($_PUT['answerTo'])),
                $_PUT['text'],
                $_PUT['picture']
            );
    print_result($id);
};

$comment_photo_PUT = function($args){
            $file = fopen('php://input', 'r');
            $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWCOMMENTPHOTO');
            $tmpFile = fopen($tmpFilePath, 'w');
            while($data = fread($file, 1024)){
                fwrite($tmpFile, $data);
            }
    print_result(basename($tmpFilePath));
};

$comment_id_GET = function($args){
    $id = $args[1];
    $ret = getPetComment($id);
    print_result($ret);
};

$comment_id_PUT = function($args){
    $id = $args[1];

                    $string = file_get_contents("php://input");
                    $_PUT = json_decode($string, true);
                    $ret = editPetComment(
                        $id,
                        $_PUT['text'],
                        false,
                        null
                    );
    print_result($ret);
};

$comment_id_photo_PUT = function($args){
    $id = $args[1];

            // TODO: Replace this part by a PUT request to comment/photo
            $file = fopen('php://input', 'r');
            $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWCOMMENTPHOTO');
            $tmpFile = fopen($tmpFilePath, 'w');
            while($data = fread($file, 1024)){
                fwrite($tmpFile, $data);
            }

            setCommentPhoto($id, $tmpFilePath);
    
    print_result("comment/{$id}/photo");
};

$comment_id_photo_DELETE = function($args){
    $id = $args[1];

            try{
                deletePetCommentPhoto($id);
                print_result("comment/{$id}/photo");
            } catch(CouldNotDeleteFileException $e){
                http_response_code(404); die();
            }
};
