<?php

require_once SERVER_DIR.'/database/connection.php';
require_once SERVER_DIR . '/authentication.php';
Authentication\verifyCSRF_Token();
require_once SERVER_DIR.'/classes/Pet.php';

$comment = Comment::fromDatabase(intval($_POST['id']));

if($comment == null){ my_response_code(400); die(); }
if (isset($_SESSION['username']) && $_SESSION['username'] === $comment->getUserId()){
    try {
        deletePetComment($_POST['id']);
    }
    catch(Exception $e) { }
}

header("Location: ". $_SERVER['HTTP_REFERER']);

die();
