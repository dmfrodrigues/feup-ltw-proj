<?php
require_once __DIR__ . '/../../server.php';
require_once __DIR__ . '/../../authentication.php';
require_once __DIR__ . '/../../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/classes/Pet.php';

$comment_PUT = function(array $args): void{
    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::WRITE  ,
        $auth,
        null
    );

    $_PUT = getPUT();
    $id = addPetComment(
        $_PUT['petId'],
        $_PUT['username'],
        ($_PUT['answerTo'] === '' ? null : intval($_PUT['answerTo'])),
        $_PUT['text'],
        $_PUT['picture']
    );
};

$comment_photo_PUT = function(array $args): void{
    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::WRITE  ,
        $auth,
        null
    );

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
    if($comment == null){ my_response_code(404); die(); }

    $auth = Authentication\check(true);
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::READ   ,
        $auth,
        $comment
    );

    print_result($comment);
};

$comment_id_PUT = function(array $args): void{
    $id = $args[1];
    $comment = Comment::fromDatabase($id);

    $_PUT = getPUT();
    
    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::EDIT   ,
        $auth,
        $comment
    );
    
    editPetComment(
        $id,
        $_PUT['text'],
        false,
        null
    );
};

$comment_id_DELETE = function(array $args): void{
    $id = intval($args[1]);
    $comment = Comment::fromDatabase($id);
    if($comment == null){ my_response_code(404); die(); }

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::WRITE  ,
        $auth,
        $comment
    );

    $comment->delete();

    print_result("comment/{$comment->getId()}");
};

$comment_id_photo_GET = function(array $args): void{
    $id = intval($args[1]);
    $comment = Comment::fromDatabase($id);

    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::READ   ,
        null,
        $comment
    );

    header_location("/resources/img/comments/{$id}.jpg");
    exit();
};

$comment_id_photo_PUT = function(array $args): void{
    $id = $args[1];
    $comment = Comment::fromDatabase($id);

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::EDIT   ,
        $auth,
        $comment
    );

    // TODO: Replace this part by a PUT request to comment/photo
    $file = fopen('php://input', 'r');
    $tmpFilePath = tempnam(sys_get_temp_dir(), 'NEWCOMMENTPHOTO');
    $tmpFile = fopen($tmpFilePath, 'w');
    while($data = fread($file, 1024)){
        fwrite($tmpFile, $data);
    }

    setCommentPhoto($id, $tmpFilePath);
};

$comment_id_photo_DELETE = function(array $args): void{
    $id = intval($args[1]);
    $comment = Comment::fromDatabase($id);

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::WRITE  ,
        $auth,
        $comment
    );

    try{
        deletePetCommentPhoto($id);
        print_result("comment/{$id}/photo");
    } catch(CouldNotDeleteFileException $e){
        my_response_code(404); die();
    }
};
