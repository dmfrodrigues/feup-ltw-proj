<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/pets.php';

$pet_id_comments_GET = function(array $args): void{
    $id = intval($args[1]);
    $pet = Pet::fromDatabase($id);
    $ret = $pet->getComments($id);

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT,
        Authorization\Method  ::READ  ,
        $auth,
        null
    );

    print_result($ret);
};
