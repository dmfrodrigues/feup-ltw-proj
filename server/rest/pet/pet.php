<?php
require_once __DIR__ . '/../api_constants.php';
require_once API_DIR . '/authentication.php';
require_once API_DIR . '/authorization.php';
require_once API_DIR . '/print.php';
require_once SERVER_DIR . '/pets.php';

$pet_id_comments_GET = function($args): void{
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
