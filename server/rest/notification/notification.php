<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/notifications.php';

$notification_id_PUT = function(array $args): void{
    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::COMMENT, // TODO: change to NOTIFICATION
        Authorization\Method  ::WRITE  ,
        $auth,
        null
    );
    
    $_PUT = getPUT();

    $id = addNotification(
        $_PUT['username'],
        $_PUT['subject'],
        $_PUT['text']
    );
};

