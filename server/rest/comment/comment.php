<?php
require_once __DIR__ . '/../api_constants.php';
require_once SERVER_DIR . '/pets.php';

$comment_PUT = function(array $args): void{
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

$comment_photo_PUT = function(array $args): void{
    $file = fopen('php://input', 'r');
    $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWCOMMENTPHOTO');
    $tmpFile = fopen($tmpFilePath, 'w');
    while($data = fread($file, 1024)){
        fwrite($tmpFile, $data);
    }
    print_result(basename($tmpFilePath));
};

$comment_id_GET = function(array $args): void{
    $id = intval($args[1]);
    $comment = Comment::fromDatabase($id);

    print_result($comment);
};

$comment_id_PUT = function(array $args): void{
    $id = $args[1];
    $comment = Comment::fromDatabase($id);

    $string = file_get_contents("php://input");
    $_PUT = json_decode($string, true);
    
    editPetComment(
        $id,
        $_PUT['text'],
        false,
        null
    );
};

$comment_id_photo_GET = function(array $args): void{
    $id = intval($args[1]);
    $comment = Comment::fromDatabase($id);

    $url = PROTOCOL_SERVER_URL . "/resources/img/comments/{$id}.jpg";
    header("Location: {$url}");
    exit();
};

$comment_id_photo_PUT = function(array $args): void{
    $id = $args[1];
    $comment = Comment::fromDatabase($id);

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

$comment_id_photo_DELETE = function(array $args): void{
    $id = intval($args[1]);
    $comment = Comment::fromDatabase($id);

    try{
        deletePetCommentPhoto($id);
        print_result("comment/{$id}/photo");
    } catch(CouldNotDeleteFileException $e){
        http_response_code(404); die();
    }
};
