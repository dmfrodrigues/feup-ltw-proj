<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/User.php';
require_once SERVER_DIR . '/Notification.php';

$notification_id_PUT = function(array $args): void{
    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::NOTIFICATION,
        Authorization\Method  ::WRITE  ,
        $auth,
        null
    );
    
    $_PUT = getPUT();

    $user = User::fromDatabase($_PUT['username']);

    $id = addNotification(
        $user,
        $_PUT['subject'],
        $_PUT['text']
    );
};

$notification_id_DELETE = function(array $args): void{
    $username = $args[1];

    $auth = Authentication\check();
    Authorization\checkAndRespond(
        Authorization\Resource::NOTIFICATION,
        Authorization\Method  ::WRITE  ,
        $auth,
        null
    );

    deleteAllNotifications($username);
};

