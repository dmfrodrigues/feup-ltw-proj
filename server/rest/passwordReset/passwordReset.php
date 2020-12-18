<?php
require_once __DIR__ . '/../api_main.php';
require_once __DIR__ . '/../authentication.php';
require_once __DIR__ . '/../authorization.php';
require_once __DIR__ . '/../read.php';
require_once __DIR__ . '/../print.php';
require_once SERVER_DIR . '/PasswordResetToken.php';

$passwordReset_GET = function(array $args): void {
    if(strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false){ my_response_code(415); die(); }
    require_once CLIENT_DIR.'/reset_password.php';
};

$passwordReset_PUT = function(array $args): void {
    $_PUT = getPUT();
    $username = $_PUT['username'];
    
    $user = User::fromDatabase($username);
    if($user == null) exit();
    
    $reset = new PasswordResetToken();
    $reset->setUser($username);
    $reset->generateToken();
    $reset->addToDatabase();

    $subject = "Forever Home Password Reset";
    $content =
        "Hello {$user->getName()},\r\n".
        "\r\n".
        "You requested to reset the password for your Forever Home account {$user->getUsername()} ".
        "with the email address {$user->getEmail()}. ".
        "Please click the following link to reset your password:\r\n".
        PROTOCOL_API_URL."/passwordReset/reset/?token={$reset->getToken()}\r\n".
        "\r\n".
        "This link is only available for 24h.\r\n".
        "\r\n".
        "Best regards,\r\n".
        "The Forever Home Team\r\n".
        "foreverhomeorg@gmail.com\r\n".
        "\r\n".
        "If you did not request a password reset, please feel free to ignore this message.\r\n"
    ;
    $message = new EmailMessage();
    $message->addReceiver($user->getEmail(), $user->getName());
    $message->setSubject($subject);
    $message->setBody($content);

    global $emailServer;
    $emailServer->sendMessage($message);
};
